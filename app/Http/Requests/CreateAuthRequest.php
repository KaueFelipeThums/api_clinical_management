<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class CreateAuthRequest extends BaseRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'senha' => [
                'required',
                'string',
                'max:255',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9]/',
            ],
            'senha_confirmacao' => [
                'required',
                'string',
                'max:255',
                'same:senha',
            ]
        ];
    }
}
