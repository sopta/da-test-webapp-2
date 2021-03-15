<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\Term;

use Illuminate\Foundation\Http\FormRequest;

class CreateTermRequest extends FormRequest
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
            'category_id'   => 'required|exists:categories,id',
            'start'         => 'required|date_format:d.m.Y',
            'end'           => 'required|date_format:d.m.Y|after_or_equal:start',
            'opening'       => 'nullable|date_format:d.m.Y H:i',
            'price'         => 'required|integer|min:1',
            'note_public'   => 'nullable|string|max:65000',
            'note_private'  => 'nullable|string|max:65000',
        ];

        return $rules;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        $data = [
            'category_id' => $this->input('category_id'),
            'opening' => \getCarbon($this->input('opening')),
            'price' => \intval($this->input('price')),
            'start'             => \getCarbon($this->input('start')),
            'end'               => \getCarbon($this->input('end')),
            'note_public'       => \secureMarkdown($this->input('note_public')),
            'note_private'      => \secureMarkdown($this->input('note_private')),
        ];

        return $data;
    }
}
