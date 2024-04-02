<?php

namespace Notifications;

use NW\WebService\References\Operations\Notification\Contractor;
use Operations\Notifications\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    public function findById(int $id): Contractor {
        return Contractor::getById($id);
    }
}