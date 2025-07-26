<?php

beforeEach(function () {
    $this->setTestUri('https://admin');

    $res = Http::post($this->testUrl.'v2/auth/login', [
        'email' => 'admin@admin.com',
        'password' => '123123',
    ]);

    Cache::put('auth_token', 'Bearer '.$res->json('access_token'), now()->addMinutes(10));
    $this->authHeader = ['Authorization' => Cache::get('auth_token')];

    $name = fake('ru')->company();
    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl.'v2/cabinet/management/offers/create', [
            'name' => $name,
            'slug' => \Str::slug($name),
            'system_prompt' => 'Нужно захватить мир',
            'max_users' => 20,
            'expired_at' => now()->addDays(3),
        ]);

    $this->offerId = $res->json('id');
});

test('Создать промокод', function () {
    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl.'v2/cabinet/users/promocodes', [
            'offer_id' => $this->offerId,
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

    $res = Http::withHeaders($this->authHeader)
        ->patch($this->testUrl."v2/cabinet/users/promocodes/$promocodeId", [
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
    $res = Http::withHeaders($this->authHeader)
        ->get($this->testUrl.'v2/cabinet/users/promocodes/all', [
            'offer_id' => $this->offerId
        ]);

    expect($res->status())->toBe(200);
});

test('Получить детальную информацию по промокоду', function () {
    $promocodeId = Cache::get('promocode_id');

    $res = Http::withHeaders($this->authHeader)
        ->get($this->testUrl."v2/cabinet/users/promocodes/$promocodeId/detail");

    expect($res->status())->toBe(200);
});
