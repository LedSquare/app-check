<?php

use Tests\Config;

beforeEach(function () {
    /** @var Config $this */
    $this->setTestUri('https://admin');

    $res = Http::post($this->testUrl.'v2/auth/login', [
        'email' => 'admin@admin.com',
        'password' => '123123',
    ]);

    Cache::put('auth_token', 'Bearer '.$res->json('access_token'), now()->addMinutes(10));
    $this->authHeader = ['Authorization' => Cache::get('auth_token')];
});

test('Получить список платежей', function () {

    $res = Http::withHeaders($this->authHeader)
        ->get($this->testUrl."v2/cabinet/billing/payments?per_page=19&page=1");

    expect($res->status())->toBe(200);
});

