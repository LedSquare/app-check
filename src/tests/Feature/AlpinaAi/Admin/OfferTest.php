<?php

use Tests\Config;
use Tests\Configs\AlpinaAiConfig;


beforeEach(function () {
    /** @var Config $this */
    $alpina = new AlpinaAiConfig('https://admin');
    $this->alpinaAiConfig = $alpina;

    $this->authHeader = ['Authorization' => $this->alpinaAiConfig->adminAuth()];
    $this->offerId = Cache::get('offer_id');
});


test('Создание оффера', function () {

    $company = fake()->company();
    $res = $this->alpinaHttp()->withHeaders($this->header)->post('v2/cabinet/management/offers/create', [
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

    $res = $this->alpinaHttp()->withHeaders($this->header)
        ->get('v2/cabinet/management/offers', [
            'per_page' => 15,
            'page' => 1,
        ]);

    expect($res->status())->toBe(200);
});

test('Поиск оффера', function () {
    $res = $this->alpinaHttp()->withHeaders($this->header)
        ->get('v2/cabinet/management/offers/search', [
            'search' => 'test',
            'limit' => 10,
            'offset' => 0,
        ]);

    expect($res->status())->toBe(200);
});

test('Получить оффер по id', function () {
    $res = $this->alpinaHttp()->withHeaders($this->header)
        ->get('v2/cabinet/management/offers/'.$this->offerId);

    expect($res->status())->toBe(200);
});

test('404. Получить оффер по id', function () {
    $res = $this->alpinaHttp()->withHeaders($this->header)
        ->get('v2/cabinet/management/offers/'.fake()->uuid());


    expect($res->status())->toBe(404);
});

test('Обновить оффер', function () {
    $res = $this->alpinaHttp()->withHeaders($this->header)
        ->patch('v2/cabinet/management/offers/'.$this->offerId, [
            'system_prompt' => fake()->text(150),
            'name' => $name = fake()->name(),
            'slug' => \Str::slug($name),
            'max_users' => 84,
            'expired_at' => now()->addYear(),
        ]);

    expect($res->status())->toBe(200);
});

test('Статистика оффера', function () {
    $res = $this->alpinaHttp()->withHeaders($this->header)
        ->get('v2/cabinet/management/offers/'.$this->offerId.'/stats');

    expect($res->status())->toBe(200);
});


test('Скачать файл статистики пользователей оффера', function () {
    // $res = $this->alpinaAdminHttp()->withHeaders($this->header)
    //     ->get('v2/cabinet/management/offers/'.$this->offerId.'/costs/download', [
    //         'start' => '2025-01-01',
    //         'end' => '2025-02-01',
    //         'user_ids' => [
    //             "cmcx4azl60009nznn1vwvgej7",
    //             "cmcx3qrzs0008nznnts3ekdqu",
    //             "cmcx0t5zv0005nznn0f6plpb4",
    //             "cmcw0fs8g001vtann0olyfzng",
    //             "cmcvp15i8001qtannq6d6mic9",
    //             "cmcvn4lq3001otannn51dflvp",
    //             "cmcus1f59001mtannwyb4l5xf",
    //             "cmcurq7lt001ltannm734khp7",
    //             "cmcunc9ip001jtannynvqw2cv",
    //             "cmculuft9001htannj8w2meo2",
    //             "cmculh0d0001gtann218355rc",
    //             "cmculffzk001ftannehh1lu9f",
    //             "cmculerey001etannm244u70d",
    //             "cmculeool001dtannq5t3ub0j",
    //             "cmculat81000h0snnm0qacc3t",
    //             "cmculafx0001atannakorc3z1",
    //             "cmculacml0019tannukopmzy7",
    //             "cmcul9vp20018tann1nzrpf3n",
    //             "cmcul7wmh0017tann2zbih4zz",
    //             "cmcul7jb3000g0snnomrb5zjl",
    //             "cmcul6qa80016tannu84dihf9",
    //             "cmcul6qcc000f0snn39e8oknc",
    //             "cmcul6kwf0015tannjh4249zf",
    //             "cmcul6k380014tannh10fdy02",
    //             "cmcul6cyu0013tannjlhjhhet",
    //             "cmcul6ax60012tann3bzf79g0",
    //             "cmcul5zx50011tannm3yetk2f",
    //             "cmcul5xwo0010tannbpj5bnj3",
    //             "cmcul5rzb000ztannng85bnzc",
    //         ]
    //     ]);

    // TODO: Кажется метод не работает
    // dd($res->json());
    // expect($res->status())->toBe(200);
});

test('Создать оффер', function () {
    $name = fake('ru')->company();
    $res = $this->alpinaHttp()->withHeaders($this->header)
        ->post('v2/cabinet/management/offers/create', [
            'name' => $name,
            'slug' => \Str::slug($name),
            'system_prompt' => 'Нужно захватить мир',
            'max_users' => 20,
            'expired_at' => now()->addDays(3),
        ]);

    expect($res->status())->toBe(201);
});
