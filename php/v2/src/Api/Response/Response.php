<?php

namespace NW\WebService\References\Operations\Notification\Request;

class Response
{
    public function __construct(
        private array $data,
        private int $code,
    )
    {
    }

    public function toJson(): string {
        return json_encode($this->data);
    }

    public function getCode(): int
    {
        return $this->code;
    }
}