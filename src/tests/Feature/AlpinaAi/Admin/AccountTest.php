<?php

use Illuminate\Support\Facades\Cache;
use Tests\Config;
use Tests\Configs\AlpinaAiConfig;

beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];
    $this->alpinaHttp()->withHeaders($this->authHeader);

    return Cache::remember('account_offer_id', now()->addMinutes(10), function () {
        $name = fake('ru')->company();
        $res = $this->alpinaHttp()
            ->post('v2/cabinet/management/offers/create', [
                'name' => $name,
                'slug' => \Str::slug($name),
                'system_prompt' => 'Нужно захватить мир',
                'max_users' => 20,
                'expired_at' => now()->addDays(3),
            ]);

        return $res->json('id');
    });
});

test('Получить данные лицевого счета по id владельца', function () {
    /** @var Config $this */
    $offerId = Cache::get('account_offer_id');
    $res = $this->alpinaHttp()
        ->get("v2/cabinet/billing/balance/{$offerId}");

    expect($res->status())->toBe(200);
});

