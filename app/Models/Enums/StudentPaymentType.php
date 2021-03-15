<?php

declare(strict_types=1);

namespace CzechitasApp\Models\Enums;

class StudentPaymentType extends Enum
{
    /**
     * Order types constants
     */
    public const TRANSFER       = 'transfer';
    public const POSTAL_ORDER   = 'postal_order';
    public const FKSP           = 'fksp';
    public const CASH           = 'cash';
}
