<?php

declare(strict_types=1);

namespace CzechitasApp\Policies;

use CzechitasApp\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the list of exports.
     */
    public function list(User $user): bool
    {
        $listRule = $this->fullTerm($user) || $this->overUnderPaid($user);

        return $listRule;
    }

    /**
     * Determine whetever the user can download fullTerm export
     */
    public function fullTerm(User $user): bool
    {
        return $user->isAdminOrMore();
    }

    /**
     * Determine whetever the user can download export of over or under paid students
     */
    public function overUnderPaid(User $user): bool
    {
        return $user->isAdminOrMore();
    }
}
