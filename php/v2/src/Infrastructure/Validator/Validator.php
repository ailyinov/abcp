<?php

/*
 * Validator stub, parsing rules, return errors
 */

use NW\WebService\References\Operations\Notification\Seller;

class Validator
{
    /**
     * @return array validation errors
     */
    public function validate(array $request): array
    {
        $errors = [];

        if (!isset($request['resellerId']) || empty((int)$request['resellerId'])) {
            $errors['notificationClientBySms']['message'] = 'Empty resellerId';
        }

        if (!isset($request['notificationType']) || empty((int)$request['notificationType'])) {
            $errors['Empty notificationType'] = 'Empty notificationType';
        }

        if (isset($request['resellerId'])) {
            $reseller = Seller::getById((int)$request['resellerId']);
            if ($reseller === null) {
                $errors['Seller not found!'] = 'Seller not found!';
            }
        }

        /*
         * Ect, all input validation here notification and template both
         *
         */


//        $client = Contractor::getById((int)$data['clientId']);
//        if ($client === null || $client->type !== Contractor::TYPE_CUSTOMER || $client->Seller->id !== $resellerId) {
//            throw new \Exception('сlient not found!', 400);
//        }
//
//        $cFullName = $client->getFullName();
//        if (empty($client->getFullName())) {
//            $cFullName = $client->name;
//        }
//
//        $cr = Employee::getById((int)$data['creatorId']);
//        if ($cr === null) {
//            throw new \Exception('Creator not found!', 400);
//        }
//
//        $et = Employee::getById((int)$data['expertId']);
//        if ($et === null) {
//            throw new \Exception('Expert not found!', 400);
//        }



        return $errors;
    }
}