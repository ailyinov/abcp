<?php

namespace Operations\Notifications;
use NW\WebService\References\Operations\Notification\Status;

class EmailTemplate
{
    const string DATE_FORMAT = 'Y-m-d H:i:s';

    private string $creatorName;

    private string $expertName;

    private string $clientName;

    public function __construct(
        readonly private int       $complaintId,
        readonly private string    $complaintNumber,
        readonly private int       $creatorId,
        readonly private int       $expertId,
        readonly private int       $clientId,
        readonly private int       $consumptionId,
        readonly private string    $consumptionNumber,
        readonly private string    $agreementNumber,
        readonly private array     $differences,
        readonly private \DateTime $date,
    )
    {
    }

    public function getTemplateData(NotificationTypeEnum $notificationType, int $resellerId): array
    {
        return [
            'COMPLAINT_ID' => $this->complaintId,
            'COMPLAINT_NUMBER' => $this->complaintNumber,
            'CREATOR_ID' => $this->creatorId,
            'CREATOR_NAME' => $this->creatorName,
            'EXPERT_ID' => $this->expertId,
            'EXPERT_NAME' => $this->expertName,
            'CLIENT_ID' => $this->clientId,
            'CLIENT_NAME' => $this->clientName,
            'CONSUMPTION_ID' => $this->consumptionId,
            'CONSUMPTION_NUMBER' => $this->consumptionNumber,
            'AGREEMENT_NUMBER' => $this->agreementNumber,
            'DATE' => $this->date->format(self::DATE_FORMAT),
            'DIFFERENCES' => $this->differences($notificationType, $resellerId),
        ];
    }

    public function setCreatorName(string $creatorName): void
    {
        $this->creatorName = $creatorName;
    }

    public function setExpertName(string $expertName): void
    {
        $this->expertName = $expertName;
    }

    public function setClientName(string $clientName): void
    {
        $this->clientName = $clientName;
    }

    private function differences(NotificationTypeEnum $notificationType, int $resellerId): string
    {
        $differences = '';
        if ($notificationType->type() === NotificationTypeEnum::NEW->type()) {
            $differences = $this->__('NewPositionAdded', null, $resellerId);
        } elseif ($notificationType->type() === NotificationTypeEnum::CHANGE->type() && !empty($this->differences)) {
            $differences = $this->__('PositionStatusHasChanged', [
                'from' => Status::getName($this->differences['from']),
                'to' => Status::getName($this->differences['to']),
            ], $resellerId);
        }

        return $differences;
    }

    public function getDifferences(): array
    {
        return $this->differences;
    }

    /**
     * Stub for whatever it is
     * @param string $string
     * @param ?array $data
     * @param int $resellerId
     * @return string
     */
    public function __(string $string, ?array $data, int $resellerId)
    {
        return '';
    }
}