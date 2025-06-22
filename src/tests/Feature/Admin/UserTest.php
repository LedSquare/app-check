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
