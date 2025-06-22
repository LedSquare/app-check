<?php

namespace Tests;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Config extends TestCase
{
    public string $testUrl;
    // public PendingRequest|Http $http;

    public function setTestUri(string $subDomain): void
    {
        $this->testUrl = $subDomain.'.'.env('TEST_TOP_DOMAIN').'/';
    }

    // public function setHttp(PendingRequest $http): PendingRequest
    // {

    //     return $this->http = $http;
    // }
}
