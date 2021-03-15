<?php

declare(strict_types=1);

namespace CzechitasApp\Policies;

use CzechitasApp\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     */
    public function list(User $user): bool
    {
        return $user->isRoleMaster();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->isRoleMaster();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isRoleMaster();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->isRoleMaster();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->isRoleMaster() && !$model->is_blocked;
    }

    /**
     * Determine whether the user can unblock blocked user.
     */
    public function block(User $user, User $model): bool
    {
        return $this->delete($user, $model);
    }

    /**
     * Determine whether the user can unblock blocked user.
     */
    public function unblock(User $user, User $model): bool
    {
        return $user->isRoleMaster() && $model->is_blocked;
    }
}
