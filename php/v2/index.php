<?php

require __DIR__ . '/vendor/autoload.php';

use Notifications\ClientRepository;
use Notifications\EmployeeRepository;
use NW\WebService\References\Operations\Notification\Infrastructure\RabbitMqBus;

$reqs = [
    [
        'data' => [
            'resellerId' => 1,
            'notificationType' => 1,
            'clientId' => 1,
            'creatorId' => 2,
            'expertId' => 3,
            'complaintId' => 4,
            'complaintNumber' => 1,
            'consumptionId' => 1,
            'consumptionNumber' => 1,
            'agreementNumber' => 1,
            'date' => '2024-01-01 00:00:00',
            'differences' => [
                'from' => 0,
                'to' => 1,
            ]
        ]
    ],
    [
        'data' => [
//            'resellerId' => 1,
            'notificationType' => 1,
            'clientId' => 1,
            'creatorId' => 2,
            'expertId' => 3,
            'complaintId' => 4,
            'complaintNumber' => 1,
            'consumptionId' => 1,
            'consumptionNumber' => 1,
            'agreementNumber' => 1,
            'date' => '2024-01-01 00:00:00',
            'differences' => [
                'from' => 0,
                'to' => 1,
            ]
        ]
    ],
    [
        'data' => [
            'resellerId' => 1,
            'notificationType' => 2,
            'clientId' => 1,
            'creatorId' => 2,
            'expertId' => 3,
            'complaintId' => 4,
            'complaintNumber' => 1,
            'consumptionId' => 1,
            'consumptionNumber' => 1,
            'agreementNumber' => 1,
            'date' => '2024-01-01 00:00:00',
            'differences' => [
                'from' => 0,
                'to' => 1,
            ]
        ]
    ],
    [],
];

$operation = new Operation(new ClientRepository(), new EmployeeRepository(), new RabbitMqBus());

$controller = new NotifyOperation(new Validator(), $operation);

foreach ($reqs as $r) {
    $_REQUEST = $r;

    try {
        $r = $controller->doOperation();
        print_r($r->toJson());
        echo "\n";
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
