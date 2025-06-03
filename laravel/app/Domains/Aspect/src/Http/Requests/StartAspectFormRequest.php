<?php

namespace Aspect\Http\Requests;

use Aspect\Http\Requests\Core\ActionFormRequest;

class StartAspectFormRequest extends ActionFormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }


    public function messages(): array
    {
        return [];
    }
}
