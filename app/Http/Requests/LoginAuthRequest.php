<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class LoginAuthRequest extends BaseRequest
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
            'email' => 'required|string|max:255|email',
            'senha' => 'required|string|max:255'
        ];
    }
}
