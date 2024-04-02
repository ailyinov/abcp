<?php

namespace Notifications;
use NW\WebService\References\Operations\Notification\Contractor;
use Operations\Notifications\ResellerRepositoryInterface;

class ResellerRepository implements ResellerRepositoryInterface
{
    public function findById(int $id): Contractor {
        return Contractor::getById($id);
    }
}