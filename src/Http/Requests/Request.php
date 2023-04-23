<?php

namespace App\Http\Requests;

class Request
{
    private $requestData;

    public function __construct(array $requestData)
    {
        $this->requestData = $requestData;
    }

    public function getRequestData(): array
    {
        return $this->requestData;
    }
}