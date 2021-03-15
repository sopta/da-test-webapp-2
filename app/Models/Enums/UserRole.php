<?php

declare(strict_types=1);

namespace CzechitasApp\Models\Enums;

class UserRole extends Enum
{
    /**
     * User role constants
     */
    public const MASTER       = 'master';
    public const ADMIN        = 'admin';
    public const PARENT      = 'parent';
}
