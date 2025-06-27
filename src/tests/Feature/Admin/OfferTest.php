<?php


beforeEach(function () {
    $this->setTestUri('https://admin');

    $this->header = ['authorization' => Cache::get('auth_token')];
});


test('Создание оффера', function () {

    $company = fake()->company();
    $res = Http::withHeaders($this->header)->post($this->testUrl.'v2/cabinet/management/offers/create', [
        'name' => $company,
        'slug' => \Str::slug($company),
        'system_prompt' => 'Какой то там тестовый промпт',
        'max_users' => fake()->numberBetween(10, 100),
        'expired_at' => now()->addYear()->format('Y-m-d'),
    ]);

    expect($res->status())->toBe(201);

    $this->offerId = $res->json('id');
    Cache::put('offer_id', $this->offerId, now()->addMinutes(10));
});


test('Получить список офферов', function () {

    $res = Http::withHeaders($this->header)
        ->get($this->testUrl.'v2/cabinet/management/offers', [
            'per_page' => 15,
            'page' => 1,
        ]);

    expect($res->status())->toBe(200);
});

test('Поиск оффера', function () {
    $res = Http::withHeaders($this->header)
        ->get($this->testUrl.'v2/cabinet/management/offers/search', [
            'search' => 'test',
            'limit' => 10,
            'offset' => 0,
        ]);

    expect($res->status())->toBe(200);
});

test('Получить оффер по id', function () {
    $res = Http::withHeaders($this->header)
        ->get($this->testUrl.'v2/cabinet/management/offers/'.Cache::get('offer_id'));

    expect($res->status())->toBe(200);
});

test('404. Получить оффер по id', function () {
    $res = Http::withHeaders($this->header)
        ->get($this->testUrl.'v2/cabinet/management/offers/'.fake()->uuid());

    expect($res->status())->toBe(404);
});

test('Обновить оффер', function () {
    $res = Http::withHeaders($this->header)
        ->patch($this->testUrl.'v2/cabinet/management/offers/'.Cache::get('offer_id'), [
            'system_prompt' => fake()->text(150),
            'name' => $name = fake()->name(),
            'slug' => \Str::slug($name),
            'max_users' => 84,
            'expired_at' => now()->addYear(),
        ]);

    expect($res->status())->toBe(200);
});

test('Статистика оффера', function () {
    $res = Http::withHeaders($this->header)
        ->get($this->testUrl.'v2/cabinet/management/offers/'.Cache::get('offer_id').'/stats');

    expect($res->status())->toBe(200);
});

