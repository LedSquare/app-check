<?php

use App\Models\AlpinaAi\Client;
use Illuminate\Support\Facades\Cache;
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

test('Список затрат по офферу', function () {
    /** @var Config $this */

    // Получить оффер
    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->get('v2/cabinet/management/offers/search', [
            'search' => 'alpina',
            'limit' => 1,
            'offset' => 0,
        ]);
    expect($res->status())->toBe(200);

    $offerId = $res->json(0)['id'];
    Cache::put('alpina_ai_billing_offer_id', $offerId, now()->addMinutes(10));

    // Получить список userIds
    $res = $this->alpinaHttp()
        ->get('v2/cabinet/users', [
            'per_page' => 5,
            'page' => 1,
            'offer_id' => $offerId,
        ]);
    expect($res->status())->toBe(200);

    $userIds = collect($res->json('data'))->pluck('id')->toArray();

    $alpina = new AlpinaAiConfig('https://gateway');
    $this->alpinaAiConfig = $alpina;
    $this->alpinaAiConfig->client = $this->alpinaAiConfig->clientAuth();
    $this->authHeader = ['authorization' => $this->alpinaAiConfig->client->token];

    $res = $this->alpinaHttp()->withHeaders($this->authHeader)
        ->get('v2/billing/cabinet/balance/costs/list', [
            'user_ids' => $userIds,
            'sort_cost' => 'ASC',
            'sort_name' => 'ASC',
            'start_date' => now()->subMonth()->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
        ]);

    expect($res->status())->toBe(200);
});

test('Проверка действия лицензии и баланса', function () {
    /** @var Config $this */
    $res = $this->alpinaHttp()
        ->get('v2/billing/cabinet/balance/check', [
            'search' => 'alpina',
            'limit' => 1,
            'offset' => 0,
        ]);

    expect($res->status())->toBe(402);
});

test('Получить баланс токенов по id владельца и типу счета​', function () {
    /** @var Config $this */

    $ownerId = $this->alpinaAiConfig->client->uuid;

    $res = $this->alpinaHttp()
        ->get("v2/billing/cabinet/balance/person/{$ownerId}");

    expect($res->status())->toBe(200);
});
