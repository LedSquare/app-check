<?php

use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];
});

test('Получить список платежей', function () {

    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->get("v2/cabinet/billing/payments?per_page=19&page=1");

    expect($res->status())->toBe(200);
});

