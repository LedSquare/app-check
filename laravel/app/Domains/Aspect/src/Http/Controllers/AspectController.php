<?php

namespace Aspect\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Aspect\Http\Requests\Core\ActionFormRequest;
use Aspect\Http\Resources\AspectListResource;
use Aspect\Models\Aspect;
use Aspect\Units\AspectV1Unit;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AspectController extends Controller
{
    public function start(): RedirectResponse
    {
        /** @var \App\Models\User */
        $user = auth()->user();

        if ($aspect = $user->aspects->last()) {
            $aspectUnit = AspectV1Unit::makeInstance($aspect);
            if ($aspectUnit->isEnded) {
                $aspect = $user->aspects()->create();
                $aspectUnit = AspectV1Unit::makeInstance($aspect);
            }
        } else {
            $aspect = $user->aspects()->create();
            $aspectUnit = AspectV1Unit::makeInstance($aspect);
        }
        return redirect()->route('aspect.current', $aspectUnit->aspectId);
    }

    public function next(ActionFormRequest $request, Aspect $aspect): RedirectResponse
    {
        $data = $request->validated();
        $aspectUnit = $aspect->getUnit();
        $aspectUnit->nextStep($data);

        return redirect()->route('aspect.current', $aspectUnit->aspectId);
    }

    public function current(Aspect $aspect): Response|RedirectResponse
    {
        $aspectUnit = $aspect->getUnit();
        if ($aspectUnit->isEnded) {
            return redirect()->route('aspect.report', $aspectUnit->aspectId);
        }

        /** @var \Aspect\Units\Responses\AspectInertiaResponse */
        $inertiaResponse = $aspectUnit->getStepParameters();
        return Inertia::render($inertiaResponse->component, $inertiaResponse->data);
    }

    public function list(): Response
    {
        $user = User::find(auth()->id());

        return Inertia::render('Aspect/Aspects', [
            'title' => __('Список обликов'),
            'resource' => AspectListResource::collection($user->aspects),
        ]);
    }

    public function report(Aspect $aspect): Response
    {
        $aspectUnit = $aspect->getUnit();
        $data = $aspectUnit->report();

        return Inertia::render('Aspect/Report', $data);
    }
}
