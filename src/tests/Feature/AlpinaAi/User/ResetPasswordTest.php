<?php

use App\Models\AlpinaAi\Client;
use Tests\Config;
use Tests\Traits\AlpinaAi\ClientAuthorization;

uses(ClientAuthorization::class);

beforeEach(function () {
    /** @var Config|ClientAuthorization $this */
    $this->setTestUri('https://gateway');

    $this->authHeader = ['Authorization' => $this->clientAuth($this->testUrl)];
    $this->client = Client::firstWhere('email', env('ALPINA_AI_CLIENT_TEST_EMAIL')) ?? throw new \Exception('Тестовый клиент не найден');
});

test('Отправить код​', function () {
    /** @var Config|ClientAuthorization $this */

    $res = Http::withHeaders($this->authHeader)
        ->post($this->testUrl.'v2/user/security/lostpass', [
            'email' => $this->client->email,
        ]);

    expect($res->status())->toBe(200);
});
