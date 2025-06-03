<?php

namespace App\Http\Controllers;

use Aspect\Models\Stages\Word\Word;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct()
    {
    }
    public function index(): Response
    {
        return Inertia::render('Home', [
            'title' => 'Стартовая страница',
            'user' => auth()->user()
        ]);
    }

    public function test(): Response
    {
        return Inertia::render('Some/Draggable', [
            'data' => Word::limit(10)->get(),
        ]);
    }
}
