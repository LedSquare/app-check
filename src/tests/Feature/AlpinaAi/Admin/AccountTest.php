<?php

use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];

    $name = fake('ru')->company();
    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->post('v2/cabinet/management/offers/create', [
            'name' => $name,
            'slug' => \Str::slug($name),
            'system_prompt' => 'Нужно захватить мир',
            'max_users' => 20,
            'expired_at' => now()->addDays(3),
        ]);

    $this->offerId = $res->json('id');
});

test('Получить данные лицевого счета по id владельца', function () {
    /** @var Config $this */

    $res = $this->alpinaHttp()
        ->get("v2/cabinet/billing/balance/{$this->offerId}");

    expect($res->status())->toBe(200);
});

