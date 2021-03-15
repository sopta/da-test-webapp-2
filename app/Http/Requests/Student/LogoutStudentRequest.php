<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\Student;

use CzechitasApp\Models\Enums\StudentLogOutType;
use Illuminate\Foundation\Http\FormRequest;

class LogoutStudentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'logged_out'        => 'required|in:' . \implode(',', StudentLogOutType::getAvailableValues()),
            'logged_out_reason' => 'nullable|string|max:255',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return [
            'logged_out'        => $this->input('logged_out'),
            'logged_out_reason' => $this->input('logged_out') === StudentLogOutType::OTHER
                ? $this->input('logged_out_reason')
                : null,
        ];
    }
}
