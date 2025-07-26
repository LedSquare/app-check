<?php

use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];
    $this->alpinaHttp()->withHeaders($this->authHeader);

    if (Cache::get('offer_id')) {
        return;
    }

    $name = fake('ru')->company();
    $res = $this->alpinaHttp()
        ->post('v2/cabinet/management/offers/create', [
            'name' => $name,
            'slug' => \Str::slug($name),
            'system_prompt' => 'Нужно захватить мир',
            'max_users' => 20,
            'expired_at' => now()->addDays(3),
        ]);

    Cache::put('offer_id', $res->json('id'), now()->addMinutes(10));
});

test('Создать промокод', function () {
    $offerId = Cache::get('offer_id');
    $res = $this->alpinaHttp()
        ->post('v2/cabinet/users/promocodes', [
            'offer_id' => $offerId,
            'code' => 'AUTO_PROMOCODE#'.fake()->numberBetween(1, 10000),
            'is_active' => true,
            'promo_text' => 'Опа автотестовый промокод',
            'start_at' => now()->format('Y-m-d'),
            'ended_at' => now()->addYear()->format('Y-m-d'),
            'promo_days' => 100,
            'register_limit' => 10,
            'type' => 'default',
        ]);

    expect($res->status())->toBe(200);

    Cache::put('promocode_id', $res->json('id'));
});

test('Обновить промокод​', function () {
    $promocodeId = Cache::get('promocode_id');

    $res = $this->alpinaHttp()
        ->patch("v2/cabinet/users/promocodes/$promocodeId", [
            'is_active' => true,
            'promo_text' => 'Опа автотестовый промокод, который обновили',
            'start_at' => now()->format('Y-m-d'),
            'ended_at' => now()->addYears(2)->format('Y-m-d'),
            'promo_days' => 50,
            'register_limit' => 15,
            'type' => 'default',
        ]);

    expect($res->status())->toBe(200);
});

test('Загрузить список промокодов​', function () {
    $offerId = Cache::get('offer_id');
    $res = $this->alpinaHttp()
        ->get('v2/cabinet/users/promocodes/all', [
            'offer_id' => $offerId
        ]);

    expect($res->status())->toBe(200);
});

test('Получить детальную информацию по промокоду', function () {
    $promocodeId = Cache::get('promocode_id');

    $res = $this->alpinaHttp()
        ->get("v2/cabinet/users/promocodes/$promocodeId/detail");

    expect($res->status())->toBe(200);
});
