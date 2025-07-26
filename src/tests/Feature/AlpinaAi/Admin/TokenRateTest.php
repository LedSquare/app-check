<?php

use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];
});

test('Получить настройки курса токена', function () {
    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->get("v2/cabinet/billing/rate-settings");

    expect($res->status())->toBe(200);
});

test('Настройка курса токена', function () {
    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->post("v2/cabinet/billing/rate-settings", [
            'markup' => 2,
            'token_rate' => 1.5,
            'base_token_rate' => 1,
            'usd_rate' => 82,
            'base_usd_rate' => 70,
            'markup_type' => 'value',
            'calculation_type' => 'usd',
        ]);

    expect($res->status())->toBe(200);
});




