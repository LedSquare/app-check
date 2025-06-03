<?php

namespace Aspect\Http\Controllers;

use App\Http\Controllers\Controller;
use Aspect\Units\AspectV1Unit;
use Inertia\Inertia;
use Inertia\Response;

class AspectIsActiveController extends Controller
{
    public function __invoke(): Response
    {
        /** @var \App\Models\User */
        $user = auth()->user();

        if ($aspect = $user->aspects->last()) {
            $response = $aspect->isEnded;
        } else {
            $response = false;
        }
        return Inertia::render('Home', [
            'isActive' => $response,
        ]);
    }
}
