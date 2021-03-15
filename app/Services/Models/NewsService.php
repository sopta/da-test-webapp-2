<?php

declare(strict_types=1);

namespace CzechitasApp\Services\Models;

use CzechitasApp\Models\News;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method News getContext()
 * @method Builder<News> getQuery()
 */
class NewsService extends ModelBaseService
{
    /**
     * Get FQCN category model
     */
    public function getModel(): string
    {
        return News::class;
    }

    public function getNewsListQuery(): Builder
    {
        return $this->getQuery()->orderBy('created_at', 'desc');
    }

    /**
     * Save new news and set context
     *
     * @param  array<string, mixed> $data news data
     * @return News Created news
     */
    public function insert(array $data): News
    {
        $news = $this->getModel()::create($data);
        $this->setContext($news);

        return $news;
    }

    /**
     * Update context news
     *
     * @param array<string, mixed> $data
     */
    public function update(array $data): bool
    {
        return $this->getContext()->update($data);
    }

    /**
     * Delete context news
     */
    public function delete(): ?bool
    {
        return $this->getContext()->delete();
    }
}
