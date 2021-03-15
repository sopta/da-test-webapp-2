<?php

declare(strict_types=1);

namespace CzechitasApp\Http\Requests\Order;

use CzechitasApp\Models\Enums\OrderType;
use CzechitasApp\Rules\EmailRule;
use CzechitasApp\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
    public function rules(?string $orderType = null): array
    {
        $commonRules = [
            'client'        => 'required|string|max:255',
            'ico'           => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'substitute'    => 'required|string|max:255',
            'contact_name'  => 'required|string|max:255',
            'contact_tel'   => ['required', 'string', new PhoneRule()],
            'contact_mail'  => ['required', new EmailRule(), 'max:255'],
            'start_date_1'  => 'required|date_format:d.m.Y',
            'xdata.end_date_1'  => 'required|date_format:d.m.Y',
            'start_date_2'  => 'nullable|required_with:xdata.end_date_2|date_format:d.m.Y',
            'xdata.end_date_2'  => 'nullable|required_with:start_date_2|date_format:d.m.Y',
            'start_date_3'  => 'nullable|required_with:xdata.end_date_3|date_format:d.m.Y',
            'xdata.end_date_3'  => 'nullable|required_with:start_date_3|date_format:d.m.Y',
        ];

        $typeSpecificRules = [
            'xdata.students'        => 'required|integer|min:1',
            'xdata.age'             => 'required|string|max:30',
            'xdata.adults'          => 'required|integer|min:1',
        ];
        if ($this->input(OrderType::CAMP) !== null || $orderType === OrderType::CAMP) {
            $typeSpecificRules = \array_merge($typeSpecificRules, [
                'xdata.date_part'   => 'required|in:forenoon,afternoon',
            ]);
        } else {
            $typeSpecificRules = \array_merge($typeSpecificRules, [
                'xdata.start_time'  => 'required|date_format:H:i',
                'xdata.start_food'  => 'required|in:breakfast,lunch,dinner',
                'xdata.end_time'    => 'required|date_format:H:i',
                'xdata.end_food'    => 'required|in:breakfast,lunch,dinner',
            ]);
        }

        return \array_merge($commonRules, $typeSpecificRules);
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'start_date_2.required_with' => \trans('orders.validation.required_with'),
            'xdata.end_date_2.required_with' => \trans('orders.validation.required_with'),
            'start_date_3.required_with' => \trans('orders.validation.required_with'),
            'xdata.end_date_3.required_with' => \trans('orders.validation.required_with'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(?string $orderType = null): array
    {
        $type = OrderType::CAMP;
        if ($this->input(OrderType::SCHOOL_NATURE) !== null || $orderType === OrderType::SCHOOL_NATURE) {
            $type = OrderType::SCHOOL_NATURE;
        }
        $ret = [
            'type'              => $type,
            'client'            => $this->input('client'),
            'ico'               => $this->input('ico'),
            'address'           => $this->input('address'),
            'substitute'        => $this->input('substitute'),
            'contact_name'      => $this->input('contact_name'),
            'contact_tel'       => $this->input('contact_tel'),
            'contact_mail'      => $this->input('contact_mail'),
            'start_date_1'      => \getCarbon($this->input('start_date_1')),
            'start_date_2'      => \getCarbon($this->input('start_date_2')),
            'start_date_3'      => \getCarbon($this->input('start_date_3')),
            'xdata'             => [
                'students'          => \intval($this->input('xdata.students')),
                'age'               => $this->input('xdata.age'),
                'adults'            => \intval($this->input('xdata.adults')),
                'end_date_1'        => \getCarbon($this->input('xdata.end_date_1')),
                'end_date_2'        => \getCarbon($this->input('xdata.end_date_2')),
                'end_date_3'        => \getCarbon($this->input('xdata.end_date_3')),
            ],
        ];

        if ($this->input(OrderType::CAMP) !== null || $orderType === OrderType::CAMP) {
            $ret['xdata']['date_part']      = $this->input('xdata.date_part');
        } else {
            $ret['xdata']['start_time']     = $this->input('xdata.start_time');
            $ret['xdata']['start_food']     = $this->input('xdata.start_food');
            $ret['xdata']['end_time']       = $this->input('xdata.end_time');
            $ret['xdata']['end_food']       = $this->input('xdata.end_food');
        }

        return $ret;
    }
}
