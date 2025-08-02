<?php

use App\Models\AlpinaAi\Client;
use Illuminate\Support\Facades\Cache;
use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://gateway');
    $this->alpinaAiConfig = $alpina;

    $this->alpinaAiConfig->client = $this->alpinaAiConfig->clientAuth();

    $this->authHeader = ['authorization' => $this->alpinaAiConfig->client->token];
    $this->alpinaHttp()->withHeaders($this->authHeader);
});

test('Список доступных моделей', function () {
    /** @var Config $this */

    $res = $this->alpinaHttp()
        ->get('v2/image-ai/cabinet/models');
    expect($res->status())->toBe(200);
});
