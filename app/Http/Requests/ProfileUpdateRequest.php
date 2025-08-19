<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'profile' => ['nullable','image'],
        ];
    }

    /** Messages */

    function messages(): array
    {
        return [
            "name.string" => "Le nom doit être un text",
            "name.max" => "Le nombre maximum de caractère ne doit pas dépasser 255",

            "email.email" => "Ce champ doit être de type mail.",
            "email.max" => "Le nombre maximum de caractère ne doit pas dépasser 255",
            "email.unique" => "Le mail doit être unique",

            "profile.image" => "Ce Champ doit être une image",
        ];
    }
}
