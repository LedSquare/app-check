<?php

use function Pest\Laravel\postJson;


beforeEach(fn () => $this->setTestUri('https://admin'));


test('Создание пользователя', function () {
    // $r = postJson($this->testUrl.'v2/cabinet/users', [
    //     'firstName' => fake()->firstName(),
    //     'lastName' => fake()->lastName(),
    //     'role' => 'MEMBER',
    //     'email' => fake()->email(),
    //     'password' => 'password',
    //     'entityId' => ,
    //     'send_email' => false,
    // ]);

    // dd($r->json());
});


test('Скачать файл затрат пользователей по офферу', function () {
    $res = Http::withHeaders($this->header)
        ->get($this->testUrl.'v2/cabinet/management/offers/'.Cache::get('offer_id').'/costs/download', [
            'start' => now()->subMonth(),
            'end' => now(),
            'user_ids' => [],
        ]);

    expect($res->status())->toBe(200);
})->skip();
