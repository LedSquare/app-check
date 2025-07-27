<?php

use App\Models\AlpinaAi\Client;
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

test('Скачать файл затрат пользователей оффера', function () {
    /** @var Config $this */

    $res = $this->alpinaHttp()
        ->get('v2/user/cabinet/offers/statistic/costs/download', [
            'start' => '2025-01-01',
            'end' => '2025-01-05',
        ]);

    expect($res->status())->toBe(200);
});

test('Затраты пользователей по офферу', function () {
    /** @var Config $this */

    $res = $this->alpinaHttp()
        ->get('v2/user/cabinet/offers/statistic/costs', [
            'sort_cost' => 'DESC',
            'start_date' => '2025-01-01',
            'end_date' => '2025-01-05',
        ]);

    expect($res->status())->toBe(200);
});


