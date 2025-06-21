<?php

namespace App\Http\Controllers;

use App\Configs\UrlConfig;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Testing\TestCase;

final class CheckController extends TestCase
{
    public function __construct(
        private UrlConfig $config,
    ) {
    }

    public function home(): View
    {
        $message = $this->config->baseUri;

        return view('pages.home', compact('message'));
    }
}
