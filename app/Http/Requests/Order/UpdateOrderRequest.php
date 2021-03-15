<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\Order;

use Carbon\Carbon;
use CzechitasApp\Http\Requests\Order\CreateOrderRequest;

class UpdateOrderRequest extends CreateOrderRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'final_date_from'       => \trans('orders.form.final_date_from'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(?string $orderType = null): array
    {
        $rules = parent::rules($this->route()->order->type);
        $requiredIfTerm = $this->input('save_term') === null ? 'nullable' : 'required';

        unset($rules['start_date_1']);
        unset($rules['xdata.end_date_1']);
        unset($rules['start_date_2']);
        unset($rules['xdata.end_date_2']);
        unset($rules['start_date_3']);
        unset($rules['xdata.end_date_3']);
        $rules['final_date_from']   = "{$requiredIfTerm}|date_format:d.m.Y";
        $rules['final_date_to']     = "{$requiredIfTerm}|date_format:d.m.Y|after:final_date_from";

        $typeSpecificRules = [
            'xdata.price_kid'       => "{$requiredIfTerm}|integer|min:1",
            'xdata.price_adult'     => "{$requiredIfTerm}|integer|min:0",
        ];

        return \array_merge($rules, $typeSpecificRules);
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(?string $orderType = null): array
    {
        $data = parent::getData($this->route()->order->type);
        unset($data['type']);
        unset($data['start_date_1']);
        unset($data['xdata']['end_date_1']);
        unset($data['start_date_2']);
        unset($data['xdata']['end_date_2']);
        unset($data['start_date_3']);
        unset($data['xdata']['end_date_3']);

        $data['final_date_from'] = $this->input('final_date_from') === null
            ? null
            : \getCarbon($this->input('final_date_from'));
        $data['final_date_to'] = $this->input('final_date_to') === null
            ? null
            : \getCarbon($this->input('final_date_to'));

        $data['xdata']['price_kid'] = $this->input('xdata.price_kid') === null
            ? null
            : (int)$this->input('xdata.price_kid');
        $data['xdata']['price_adult'] = $this->input('xdata.price_adult') === null
            ? null
            : (int)$this->input('xdata.price_adult');

        if ($this->input('save_term')) {
            $data['signature_date'] = Carbon::now();
        }

        return $data;
    }
}
