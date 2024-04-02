<?php

namespace Operations\Notifications;
use NW\WebService\References\Operations\Notification\Contractor;

interface EmployeeRepositoryInterface
{
    public function findById(int $id): Contractor;
}