<?php

namespace Operations\Notifications;

class Notification
{
    public function __construct(
        readonly private int $resellerId,
        readonly private NotificationTypeEnum $notificationType,
        readonly private int $clientId,
        readonly private int $creatorId,
        readonly private int $expertId,
    )
    {
    }

    public function getCreatorId(): int
    {
        return $this->creatorId;
    }

    public function getResellerId(): int
    {
        return $this->resellerId;
    }

    public function getExpertId(): int
    {
        return $this->expertId;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getNotificationType(): NotificationTypeEnum
    {
        return $this->notificationType;
    }
}