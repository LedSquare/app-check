<?php

namespace Tests\Configs;

use App\Models\AlpinaAi\Admin;
use App\Models\AlpinaAi\Client;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\Traits\AlpinaAi\ClientAuthorization;

final class AlpinaAiConfig
{
    use ClientAuthorization;

    public array $authHeader;
    public Client $client;
    public Admin $admin;

    public PendingRequest $http;
    public string $testUrl;

    public function __construct(
        public readonly string $subDomain
    ) {
        $this->admin = Admin::updateOrCreate([
            'email' => env('ALPINA_AI_ADMIN_EMAIL'),
            'password' => env('ALPINA_AI_ADMIN_PASS'),
        ]);

        $this->http = Http::withOptions([
            'base_uri' => $subDomain.'.'.env('ALPINA_AI_TOP_DOMAIN').'/',
        ]);
    }

    public function adminAuth(): string
    {
        if ($token = Cache::get('alpina_ai_admin_auth_token')) {
            return $token;
        }

        $res = Http::post('https://admin.'.env('ALPINA_AI_TOP_DOMAIN').'/'.'v2/auth/login', [
            'email' => $this->admin->email,
            'password' => $this->admin->password,
        ]);
        $token = 'Bearer '.$res->json('access_token');
        Cache::put('alpina_ai_admin_auth_token', $token, now()->addMinutes(10));

        return $token;
    }
}
