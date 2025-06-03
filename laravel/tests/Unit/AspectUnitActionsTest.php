<?php

namespace Tests\Unit;

use Aspect\Http\Requests\Core\ActionFormRequest;
use Aspect\Interfaces\Units\AspectUnitInterface;
use Aspect\Models\Aspect;
use Aspect\Units\AspectV1Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AspectUnitActionsTest extends TestCase
{
    use RefreshDatabase;
    public AspectV1Unit $aspectUnit;

    protected function setAspectUnit(): void
    {
        $this->aspectUnit = AspectV1Unit::makeInstance(Aspect::find(1));
    }

    public function test_aspect_unit_make_instance(): void
    {
        $aspectUnit = AspectV1Unit::makeInstance(Aspect::find(1));

        $this->assertEquals(AspectV1Unit::class, get_class($aspectUnit));
    }

    public function test_select_action(): void
    {
        $this->setAspectUnit();

        $request = new ActionFormRequest();

        $request->merge([
            'next_step' => true,
        ]);

        $request->

        $this->aspectUnit->selectStepOption($request);
    }

    public function test_start_aspect(): void
    {
        auth()->loginUsingId(1);

        $response = $this->get('aspect/start');

        dd($response);
    }
}
