<?php

namespace NW\WebService\References\Operations\Notification\Infrastructure;

interface BusInterface
{
    public function push();

    public function pushSms(int $resellerId, int $clientId, string $changeStatus, int $to, array $templateData, string &$error);

    public function pushEmail(array $email, int $resellerId, string $changeStatus, int $to = 1, ?int $clientId = null);
}
