<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        $rules = [
            'name'              => 'required|string|max:50',
            'cover_img'         => 'mimes:jpeg,png',
            'content'           => 'nullable|string|max:65000',
        ];

        return $rules;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return [
            'name'              => $this->input('name'),
            'cover_img'         => $this->file('cover_img'),
            'content'           => \secureMarkdown($this->input('content')),
        ];
    }
}
