<?php

use NW\WebService\References\Operations\Notification\Infrastructure\BusInterface;
use NW\WebService\References\Operations\Notification\NotificationEvents;
use Operations\Notifications\ClientRepositoryInterface;
use Operations\Notifications\EmailTemplate;
use Operations\Notifications\EmployeeRepositoryInterface;
use Operations\Notifications\Notification;
use Operations\Notifications\NotificationTypeEnum;
use function NW\WebService\References\Operations\Notification\getEmailsByPermit;
use function NW\WebService\References\Operations\Notification\getResellerEmailFrom;

class Operation
{
    public function __construct(
        readonly private ClientRepositoryInterface $clientRepository,
        readonly private EmployeeRepositoryInterface $employeeRepository,
        readonly private BusInterface $bus,
    )
    {
    }

    public function doOperation(Notification $notification, EmailTemplate $emailTpl): NotificationOperationResult
    {
        $result = new NotificationOperationResult();

        $creator = $this->employeeRepository->findById($notification->getCreatorId());
        $emailTpl->setCreatorName($creator->getFullName());

        $expert = $this->employeeRepository->findById($notification->getExpertId());
        $emailTpl->setExpertName($expert->getFullName());

        $client = $this->clientRepository->findById($notification->getClientId());
        $emailTpl->setClientName($client->getFullName());

        $templateData = $emailTpl->getTemplateData($notification->getNotificationType(), $notification->getResellerId());
        $resellerId = $notification->getResellerId();
        $emailFrom = getResellerEmailFrom($notification->getResellerId());
        // Получаем email сотрудников из настроек
        $emails = getEmailsByPermit($notification->getResellerId(), 'tsGoodsReturn');
        foreach ($emails as $email) {
            $this->bus->pushEmail([
                0 => [ // MessageTypes::EMAIL
                    'emailFrom' => $emailFrom,
                    'emailTo'   => $email,
                    'subject'   => $emailTpl->__('complaintEmployeeEmailSubject', $templateData, $resellerId),
                    'message'   => $emailTpl->__('complaintEmployeeEmailBody', $templateData, $resellerId),
                ],
            ], $resellerId, NotificationEvents::CHANGE_RETURN_STATUS);
            $result->setNotificationEmployeeByEmail(true);
        }

        // Шлём клиентское уведомление, только если произошла смена статуса
        if ($this->isStatusChanged($notification, $emailTpl)) {
            if (!empty($emailFrom) && !empty($client->email)) {
                $this->bus->pushEmail([
                    0 => [ // MessageTypes::EMAIL
                        'emailFrom' => $emailFrom,
                        'emailTo'   => $client->email,
                        'subject'   =>$emailTpl->__('complaintClientEmailSubject', $templateData, $resellerId),
                        'message'   => $emailTpl->__('complaintClientEmailBody', $templateData, $resellerId),
                    ],
                ], $resellerId, NotificationEvents::CHANGE_RETURN_STATUS, $emailTpl->getDifferences()['to'], $client->id);
                $result->setNotificationClientByEmail(true);
            }

            if (!empty($client->mobile)) {
                $error = '';
                $res = $this->bus->pushSms($resellerId, $client->id, NotificationEvents::CHANGE_RETURN_STATUS, $emailTpl->getDifferences()['to'], $templateData, $error);
                if ($res) {
                    $result->setNotificationClientBySmsSent(true);
                }
                if (!empty($error)) {
                    $result->setNotificationClientBySmsMessage($error);
                }
            }
        }

        return $result;
    }

    private function isStatusChanged(Notification $notification, EmailTemplate $emailTpl): bool
    {
        return $notification->getNotificationType() === NotificationTypeEnum::CHANGE && !empty($emailTpl->getDifferences()['to']);
    }
}