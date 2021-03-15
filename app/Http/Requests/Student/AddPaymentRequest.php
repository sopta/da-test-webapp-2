<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\Student;

use Carbon\Carbon;
use CzechitasApp\Http\Requests\ModalRequest;
use CzechitasApp\Models\Enums\StudentPaymentType;

class AddPaymentRequest extends ModalRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $types = StudentPaymentType::getAvailableValues(true);
        $maxReceivedAt = Carbon::now()->format('d.m.Y');

        return [
            'direction'   => 'required|in:income,return',
            'payment'     => 'required|in:' . \implode(',', $types),
            'received_at' => "required_if:override_received_at,1|date|before_or_equal:{$maxReceivedAt}",
            'price'       => 'required|integer|min:1',
            'note'        => 'nullable|string|max:255',
        ];
    }

    /**
     * @param  array<string, mixed> $toMerge
     * @return array<string, mixed>
     */
    public function getData(array $toMerge = []): array
    {
        $returnCoefficient = $this->input('direction') === 'return' ? -1 : 1;

        $receivedAt = Carbon::now();
        if ($this->input('override_received_at') === '1') {
            $receivedAt = \getCarbon($this->input('received_at'))->setTimeFrom(Carbon::now());
        }

        return [
            'payment'     => $this->input('payment'),
            'price'       => (int)$this->input('price') * $returnCoefficient,
            'received_at' => $receivedAt,
            'note'        => $this->input('note'),
        ];
    }
}
