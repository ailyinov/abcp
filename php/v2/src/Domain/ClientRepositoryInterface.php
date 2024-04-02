<?php

namespace Operations\Notifications;
use NW\WebService\References\Operations\Notification\Contractor;

interface ClientRepositoryInterface
{
    public function findById(int $id): Contractor;
}