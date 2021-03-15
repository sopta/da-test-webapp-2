<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\Student;

use CzechitasApp\Http\Requests\ModalRequest;

class AdminCanceledStudentRequest extends ModalRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'canceled'         => 'required_if:canceled_yes,1|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'canceled.required_if' => \trans('validation.required'),
        ];
    }

    /**
     * @param  array<string, mixed> $toMerge
     * @return array<string, mixed>
     */
    public function getData(array $toMerge = []): array
    {
        return parent::getData([
            'canceled' => $this->input('canceled_yes') ? $this->input('canceled') : null,
        ]);
    }
}
