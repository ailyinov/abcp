<?php

namespace NW\WebService\References\Operations\Notification\Infrastructure;

/**
 * RabbitMq stub, push notifications into queue for further processing.
 * Could be Laravel/Symfony jobs or smtng
 */
class RabbitMqBus implements BusInterface
{

    #[\Override] public function push()
    {
        // TODO: Implement push() method.
    }

    #[\Override] public function pushSms(int $resellerId, int $clientId, string $changeStatus, int $to, array $templateData, string &$error)
    {
        // TODO: Implement pushSms() method.
    }

    #[\Override] public function pushEmail(array $email, int $resellerId, string $changeStatus, int $to = 1, ?int $clientId = null)
    {
        // TODO: Implement pushEmail() method.
    }
}