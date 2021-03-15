<?php

declare(strict_types=1);

namespace CzechitasApp\Services\Models;

use CzechitasApp\Models\Category;
use CzechitasApp\Models\Term;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * @method Term getContext()
 * @method Builder<Term> getQuery()
 */
class TermService extends ModelBaseService
{
    /**
     * Get FQCN category model
     */
    public function getModel(): string
    {
        return Term::class;
    }

    /**
     * Get list query for AJAX
     *
     * @return Builder<Term>
     */
    public function getListQuery(): Builder
    {
        return $this->getQuery();
    }

    /**
     * Get list of terms for given category
     *
     * @param  bool $onlyCanEdit Select only terms, which user can still add application
     * @return Builder<Term>
     */
    public function getTermsOfCategoryForParents(Category $category, bool $onlyCanEdit = true): Builder
    {
        $query = $this->getQuery()->where('category_id', $category->id);

        if ($onlyCanEdit) {
            $query->possibleLogin();
        }

        $query->orderBy('start');

        return $query;
    }

    /**
     * Get terms for admin to edit or create student
     * Showing terms longer, than for parent
     *
     * @return Builder<Term>
     */
    public function getTermsForAdmin(): Builder
    {
        return $this->getQuery()
            ->with(['category:id,name'])
            ->possibleAdminLogin();
    }

    /**
     * Get terms for admin to edit or create student
     * Showing terms longer, than for parent
     *
     * @return Builder<Term>
     */
    public function getTermsForExport(): Builder
    {
        return $this->getQuery()->with(['category:id,name']);
    }

    /**
     * @return Builder<Term>
     */
    public function getApiList(int $page, int $perPage): Builder
    {
        $perPage = \min(\max($perPage, 0), 100);
        $page = \max(1, $page);

        return $this->getQuery()->limit($perPage)->offset(($page - 1) * $perPage);
    }

    /**
     * Get term or fail
     */
    public function findTermOrFail(int $id): Term
    {
        return $this->getModel()::findOrFail($id);
    }

    /**
     * Save new term and set context
     *
     * @param array<string, mixed> $data Term data
     */
    public function insert(array $data): Term
    {
        try {
            $term = $this->getModel()::create($data);
            $this->setContext($term);

            return $term;
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Update context term
     *
     * @param array<string, mixed> $data
     */
    public function update(array $data): bool
    {
        try {
            return $this->getContext()->update($data);
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }

    /**
     * Update context term from Update flag request
     *
     * @param array<string, mixed> $data
     */
    public function flagUpdate(array $data): bool
    {
        return $this->getContext()->update([
            'flag' => $data['flag'] ?? null,
        ]);
    }

    /**
     * Delete context term
     */
    public function delete(): ?bool
    {
        return $this->getContext()->delete();
    }

    /**
     * Get all data needed to render valid application form
     *
     * @return array<string, mixed>
     */
    public function getNewApplicationTermData(): array
    {
        $data = $this->getContext()->only([
            'select_payment',
        ]);

        return $data;
    }
}
