<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class BaseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        App::setLocale('en');
    }

    protected function failedValidation(Validator $validator): void
    {
        throw (new \Illuminate\Validation\ValidationException($validator))->errorBag($this->errorBag);
    }
}
