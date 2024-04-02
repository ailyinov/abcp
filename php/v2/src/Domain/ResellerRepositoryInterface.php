<?php

namespace Operations\Notifications;
use NW\WebService\References\Operations\Notification\Contractor;

interface ResellerRepositoryInterface
{
    public function findById(int $id): Contractor;
}