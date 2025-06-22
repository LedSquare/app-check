<?php

use function Pest\Laravel\postJson;


beforeEach(fn () => $this->setTestUri('https://admin'));

test('Создание оффера', function () {
    $company = fake()->company();
    $res = postJson($this->testUrl.'v2/cabinet/management/offers/create', [
        'name' => $company,
        'slug' => \Str::slug($company),
        'system_prompt' => 'Какой то там тестовый промпт',
        'max_users' => fake()->numberBetween(10, 100),
        'expired_at' => now()->addYear()->format('Y-m-d'),
    ]);

    $r = expect($res->status())->json();
});


