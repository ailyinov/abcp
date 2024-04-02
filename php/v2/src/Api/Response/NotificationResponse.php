<?php

namespace NW\WebService\References\Operations\Notification\Request;

class NotificationResponse extends Response
{
    public function __construct(array $data, int $code)
    {
        parent::__construct($data, $code);
    }
}