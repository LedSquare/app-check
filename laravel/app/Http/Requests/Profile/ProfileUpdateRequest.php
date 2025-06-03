<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'string', 'unique:users,email,' . $this->user()->id],
            'firstname' => ['string', 'required'],
            'lastname' => ['string', 'nullable'],
            'fathername' => ['string', 'nullable'],
            'gender' => ['required', 'string', 'nullable', 'in:муж,жен'],
            'phone' => ['string', 'min:6']
        ];
    }

    public function messages(): array
    {
        return [
            //TODO: validation messages
            'username.min' => 'Слишком мало символов',
            'gender.in' => 'Пол может быть только муж или жен',
        ];
    }
}
