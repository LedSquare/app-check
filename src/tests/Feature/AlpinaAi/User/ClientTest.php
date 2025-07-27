<?php

use App\Models\AlpinaAi\Client;
use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://gateway');
    $this->alpinaAiConfig = $alpina;

    $this->alpinaAiConfig->client = $this->alpinaAiConfig->clientAuth();

    $this->authHeader = ['authorization' => $this->alpinaAiConfig->client->token];
    $this->alpinaHttp()->withHeaders($this->authHeader);
});

test('Массовая регистрация пользователей', function () {
    /** @var Config $this */

    $emails = [];
    while (count($emails) < 3) {
        $emails[] = fake()->email();
    }

    $res = $this->alpinaHttp()
        ->post('v2/user/cabinet/users/mass-registration', [
            'emails' => $emails,
            'offer_id' => $this->alpinaAiConfig->client->offer_id,
        ]);

    expect($res->status())->toBe(202);
});

test('Инвайт метод для приглашения пользователей с последующим созданием аккаунта​', function () {
    /** @var Config $this */

    $users = [];
    while (count($users) < 3) {
        $users[] = [
            'email' => fake()->email(),
            'role' => 'MEMBER',
        ];
    }

    $res = $this->alpinaHttp()
        ->post('v2/user/cabinet/users/auth-invite', [
            'users' => $users,
        ]);

    expect($res->status())->toBe(202);
});

test('Изменить статус пользователя', function () {
    /** @var Config $this */

    $offerId = $this->alpinaAiConfig->client->offer_id;
    $this->alpinaAiConfig = new AlpinaAiConfig('https://admin');

    $res = $this->alpinaHttp()->withHeader('authorization', $this->alpinaAiConfig->adminAuth())
        ->post('v2/cabinet/users', [
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'role' => 'MEMBER',
            'email' => fake()->email(),
            'password' => 'password',
            'entityId' => $offerId,
            'send_email' => false,
        ]);

    $userId = $res->json('user')['id'];

    $alpina = new AlpinaAiConfig('https://gateway');
    $this->alpinaAiConfig = $alpina;
    $this->alpinaAiConfig->client = $this->alpinaAiConfig->clientAuth();

    $res = $this->alpinaHttp()
        ->withHeaders(['authorization' => $this->alpinaAiConfig->client->token])
        ->patch("v2/user/cabinet/user/{$userId}/status", [
            'status' => 'blocked'
        ]);

    expect($res->status())->toBe(200);
});

test('Изменить статус пользователя. 422 - Неправильный статус', function () {
    /** @var Config $this */

    $offerId = $this->alpinaAiConfig->client->offer_id;
    $this->alpinaAiConfig = new AlpinaAiConfig('https://admin');

    $res = $this->alpinaHttp()->withHeader('authorization', $this->alpinaAiConfig->adminAuth())
        ->post('v2/cabinet/users', [
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'role' => 'MEMBER',
            'email' => fake()->email(),
            'password' => 'password',
            'entityId' => $offerId,
            'send_email' => false,
        ]);

    $userId = $res->json('user')['id'];

    $alpina = new AlpinaAiConfig('https://gateway');
    $this->alpinaAiConfig = $alpina;
    $this->alpinaAiConfig->client = $this->alpinaAiConfig->clientAuth();

    $res = $this->alpinaHttp()
        ->withHeaders(['authorization' => $this->alpinaAiConfig->client->token])
        ->patch("v2/user/cabinet/user/{$userId}/status", [
            'status' => 'qweqwr'
        ]);

    expect($res->status())->toBe(422);
});

test('Обновление профиля пользователя вместе с обновлением пользователя на старом беке', function () {
    /** @var Config $this */

    $offerId = $this->alpinaAiConfig->client->offer_id;
    $this->alpinaAiConfig = new AlpinaAiConfig('https://admin');

    $res = $this->alpinaHttp()->withHeader('authorization', $this->alpinaAiConfig->adminAuth())
        ->post('v2/cabinet/users', [
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'role' => 'MEMBER',
            'email' => fake()->email(),
            'password' => 'password',
            'entityId' => $offerId,
            'send_email' => false,
        ]);

    $userId = $res->json('user')['id'];

    $alpina = new AlpinaAiConfig('https://gateway');
    $this->alpinaAiConfig = $alpina;
    $this->alpinaAiConfig->client = $this->alpinaAiConfig->clientAuth();

    $res = $this->alpinaHttp()
        ->withHeaders(['authorization' => $this->alpinaAiConfig->client->token])
        ->patch("v2/user/cabinet/user/{$userId}", [
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'role' => 'MEMBER',
            'email' => fake()->email(),
        ]);

    expect($res->status())->toBe(200);
});

