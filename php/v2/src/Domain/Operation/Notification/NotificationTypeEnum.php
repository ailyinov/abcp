<?php

namespace Operations\Notifications;

enum NotificationTypeEnum: int
{
    case NEW = 1;
    case CHANGE = 2;

    public function type(): int
    {
        return match($this)
        {
            NotificationTypeEnum::NEW => 1,
            NotificationTypeEnum::CHANGE => 2,
        };
    }
}
