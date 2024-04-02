<?php

namespace Notifications;
use NW\WebService\References\Operations\Notification\Contractor;
use Operations\Notifications\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function findById(int $id): Contractor {
        return Contractor::getById($id);
    }
}