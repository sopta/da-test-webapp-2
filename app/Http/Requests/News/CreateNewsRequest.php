<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewsRequest extends FormRequest
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
            'title'             => 'required|string|max:100',
            'content'           => 'required|string|max:65000',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return [
            'title'             => $this->input('title'),
            'content'           => \secureMarkdown($this->input('content')),
        ];
    }
}
