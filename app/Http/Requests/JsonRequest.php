<?php

namespace App\Http\Requests;

use App\Exceptions\JsonValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class JsonRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    protected function failedValidation(Validator $validator)
    {
        throw (new JsonValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
