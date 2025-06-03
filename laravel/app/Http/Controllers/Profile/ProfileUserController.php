<?php

namespace App\Http\Controllers\Profile;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProfileUserController extends Controller
{
    public function index(): Response
    {
        if (!$user = auth()->user()) {
            return redirect()->route('login');
        }

        return Inertia::render('Profile/User', [
            'data' => $user,
        ]);
    }

    public function update(ProfileUpdateRequest $request): Response|RedirectResponse
    {
        if (!$id = auth()->id()) {
            return redirect()->route('login');
        }

        $user = User::find($id);
        $user->update($request->validated());

        return Inertia::render('Profile/User', [
            'data' => $user,
        ]);
    }
}
