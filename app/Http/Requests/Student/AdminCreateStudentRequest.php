<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\Student;

use CzechitasApp\Http\Requests\Student\CreateStudentRequest;
use CzechitasApp\Models\Term;
use Illuminate\Validation\Validator;

class AdminCreateStudentRequest extends CreateStudentRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(?Term $term = null): array
    {
        $rules = parent::rules($term);

        $rules['private_note']  = 'nullable|string|max:65000';

        unset($rules['terms_conditions']);

        return $rules;
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        // Override parent to ignore validator
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(bool $addTerm = false): array
    {
        $data = parent::getData($addTerm);

        $data['private_note'] = $this->input('private_note');

        return $data;
    }
}
