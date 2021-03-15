<?php

declare(strict_types=1);

namespace CzechitasApp\Services\Models;

use CzechitasApp\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method User getContext()
 * @method Builder<User> getQuery()
 */
class UserService extends ModelBaseService
{
    /**
     * Get FQCN category model
     */
    public function getModel(): string
    {
        return User::class;
    }

    public function getListQuery(): Builder
    {
        return $this->getQuery();
    }

    public function getUserByEmail(?string $email): ?User
    {
        if ($email === null) {
            return null;
        }

        /** @var ?User $user */
        $user = $this->getQuery()
            ->where('email', $email)
            ->first();

        return $user;
    }

    /**
     * Save new user and set context
     *
     * @param array<string, mixed> $data User data
     */
    public function insert(array $data): User
    {
        $user = $this->getModel()::create($data);
        $this->setContext($user);

        return $user;
    }

    /**
     * Update context user
     *
     * @param array<string, mixed> $data
     */
    public function update(array $data): bool
    {
        return $this->getContext()->update($data);
    }

    /**
     * Delete context user
     */
    public function delete(): ?bool
    {
        return $this->getContext()->delete();
    }

    /**
     * @return array<string, int>
     */
    public function getConstraints(): array
    {
        $constraints = [];
        $constraints['payments'] = $this->getContext()->authorPayments()->count();
        $constraints['students'] = $this->getContext()->students()->count();

        return \array_filter($constraints);
    }

    /**
     * @param array<string, int>|null $constraints
     */
    public function isDeletePossible(?array $constraints = null): bool
    {
        $totalConstraints = 0;
        if ($constraints === null) {
            $constraints = $this->getConstraints();
        }

        foreach ($constraints as $amount) {
            $totalConstraints += $amount;
        }

        return $totalConstraints === 0;
    }

    /**
     * Delete context user
     */
    public function block(): bool
    {
        return $this->getContext()->update([
            'is_blocked' => true,
        ]);
    }

    /**
     * Delete context user
     */
    public function unblock(): bool
    {
        return $this->getContext()->update([
            'is_blocked' => false,
        ]);
    }
}
