<?php

use App\Models\AlpinaAi\Client;
use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://gateway');
    $this->alpinaAiConfig = $alpina;

    $this->alpinaAiConfig->client = $this->alpinaAiConfig->clientAuth();
    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->client->token];
});

test('Скачать файл затрат пользователей оффера', function () {
    /** @var Config $this */

    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->get('v2/user/security/lostpass', [
            'start' => '2025-01-01',
            'end' => '2025-01-05',
        ]);

    expect($res->status())->toBe(200);
});
