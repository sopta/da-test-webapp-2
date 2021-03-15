<?php

declare(strict_types=1);

namespace CzechitasApp\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     */
    public function passes($attribute, $value): bool
    {
        return (bool)\preg_match('/^((\+|00)42(0|1)(\s|\.)?)?[1-9][0-9]{2}\s?[0-9]{3}\s?[0-9]{3}$/', $value);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return \trans('validation.phone');
    }
}
