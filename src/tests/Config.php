<?php

namespace Tests;

use Illuminate\Http\Client\PendingRequest;
use Tests\Configs\AlpinaAiConfig;


class Config extends TestCase
{
    public array $authHeader;

    public AlpinaAiConfig $alpinaAiConfig;

    public function alpinaHttp(): PendingRequest
    {
        return $this->alpinaAiConfig->http;
    }
}
