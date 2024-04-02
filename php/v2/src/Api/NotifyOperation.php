<?php

use NW\WebService\References\Operations\Notification\Request\NotificationResponse;
use NW\WebService\References\Operations\Notification\Request\Response as HttpResponse;
use Operations\Notifications\EmailTemplate;
use Operations\Notifications\Notification;
use Operations\Notifications\NotificationTypeEnum;

class NotifyOperation
{
    public function __construct(
        readonly private Validator $validator,
        readonly private Operation $operation
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function doOperation(): HttpResponse
    {
        $data = $this->getRequest();
        if ($data === null) {
            return new NotificationResponse(['Invalid request'], 400);
        }
        $errors = $this->validator->validate($data);
        if (!empty($errors)) {
            return new NotificationResponse($errors, 400);
        }

        $notification = $this->requestToNotificationDto($data);
        $emailTpl = $this->requestToEmailTplDto($data);

        $opRes = $this->operation->doOperation($notification, $emailTpl);


        return new NotificationResponse($opRes->toArray(), 200);
    }

    public function getRequest(): ?array
    {
        if (empty($_REQUEST['data'])) {
            return null;
        }

        return $_REQUEST['data'];
    }

    /**
     * @param array $data
     * @return Notification
     */
    public function requestToNotificationDto(array $data): Notification
    {
        return new Notification(
            $data['resellerId'],
            NotificationTypeEnum::from($data['notificationType']),
            $data['clientId'],
            $data['creatorId'],
            $data['expertId'],
        );
    }

    /**
     * @param array $data
     * @return EmailTemplate
     */
    public function requestToEmailTplDto(array $data): EmailTemplate
    {
        return new EmailTemplate(
            $data['complaintId'],
            $data['complaintNumber'],
            $data['creatorId'],
            $data['expertId'],
            $data['clientId'],
            $data['consumptionId'],
            $data['consumptionNumber'],
            $data['agreementNumber'],
            $data['differences'],
            DateTime::createFromFormat('Y-m-d H:i:s', $data['date']),
        );
    }
}