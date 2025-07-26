<?php

namespace Tests\Traits\AlpinaAi;

use App\Models\AlpinaAi\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

trait ClientAuthorization
{
    private string $adminUrl;
    public function clientAuth(): Client
    {
        /** @var \Tests\Configs\AlpinaAiConfig $this */

        $this->adminUrl = 'https://admin.'.env('ALPINA_AI_TOP_DOMAIN');

        if (! $client = Client::firstWhere('email', env('ALPINA_AI_CLIENT_TEST_EMAIL'))) {
            $client = $this->createUser();
        }

        if ($token = Cache::get('alpina_ai_client_auth_token')) {
            $client->update(['token' => $token]);
            return $client;
        }
        $token = $this->http->post('v1/auth/login', [
            'email' => $client->email,
            'password' => $client->password,
        ])->json('tokens')['access_token'];

        Cache::put('alpina_ai_client_auth_token', $token, now()->addMinutes(10));

        $client->update(['token' => $token]);

        return $client;
    }

    private function createUser(): Client
    {
        $res = Http::post($this->adminUrl.'/v2/auth/login', [
            'email' => $this->admin->email,
            'password' => $this->admin->password,
        ]);

        $token = $res->json('access_token');


        $company = fake()->company();
        $res = Http::withHeaders(['Authorization' => "Bearer $token"])->post($this->adminUrl.'/v2/cabinet/management/offers/create', [
            'name' => $company,
            'slug' => \Str::slug($company),
            'system_prompt' => 'Какой то там тестовый промпт',
            'max_users' => fake()->numberBetween(10, 100),
            'expired_at' => now()->addYear()->format('Y-m-d'),
        ]);

        $offerId = $res->json('id');

        $res = Http::withHeaders(['Authorization' => "Bearer $token"])
            ->post($this->adminUrl.'/v2/cabinet/users', [
                'firstName' => fake()->firstName(),
                'lastName' => fake()->lastName(),
                'role' => 'ADMIN',
                'email' => env('ALPINA_AI_CLIENT_TEST_EMAIL'),
                'password' => 'password',
                'entityId' => $offerId,
                'send_email' => false,
            ]);

        $data = $res->json('user');

        $client = [
            'uuid' => $data['id'],
            'offer_id' => $data['entityId'],
            'email' => $data['email'],
            'password' => 'password',
        ];

        $this->client = Client::updateOrCreate($client);
        return $this->client;
    }
}
