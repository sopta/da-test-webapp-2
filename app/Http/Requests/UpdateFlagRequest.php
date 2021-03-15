<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFlagRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'flag'      => 'nullable|string|max:20',
        ];

        return $rules;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        $data = [
            'flag'        => $this->input('flag'),
        ];

        return $data;
    }
}
