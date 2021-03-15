<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\Student;

use CzechitasApp\Http\Requests\ModalRequest;
use CzechitasApp\Models\Enums\StudentLogOutType;

class AdminLogoutStudentRequest extends ModalRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'logged_out'        => 'nullable|in:' . \implode(',', StudentLogOutType::getAvailableValues()),
            'logged_out_reason' => 'nullable|string|max:255',
        ];
    }

    /**
     * @param  array<string, mixed> $toMerge
     * @return array<string, mixed>
     */
    public function getData(array $toMerge = []): array
    {
        return parent::getData([
            'logged_out'        => $this->input('logged_out'),
            'logged_out_reason' => $this->input('logged_out') === StudentLogOutType::OTHER
                ? $this->input('logged_out_reason')
                : null,
        ]);
    }
}
