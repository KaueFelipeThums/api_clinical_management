<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{

  /**
   * handle a failed validations attempt
   * 
   * @param Illuminate\Contracts\Validation\Validator $validator
   * @return void
   * 
   * @throws Illuminate\Validation\ValidationException
   * 
   */
  protected function failedValidation(Validator $validator)
  {
    $errors = (new ValidationException($validator))->errors();
    throw new HttpResponseException(response()->json(['success' => false, 'message' => current($errors)], 422));
  }
}
