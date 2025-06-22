<?php

use App\Models\Token;


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
})->skip();


test('Получить список офферов', function () {

    $res = Http::withHeaders($this->header)
        ->get($this->testUrl.'v2/cabinet/management/offers', [
            'per_page' => 15,
            'page' => 1,
        ]);

    expect($res->status())->toBe(200);
});



