<?php

declare(strict_types=1);

namespace CzechitasApp\Models;

use CzechitasApp\Models\Term;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property string $content
 * @property int $position
 *
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 *
 * @property Category $parent
 * @property Category[] $children
 * @property Term $terms
 */
class Category extends BaseModel
{
    public const SLUG_MAX_LENGTH = 30;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<string>
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Parent relationship builder
     *
     * @return self|BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Subcategories relationship builder
     *
     * @return self|HasMany
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Terms relationship builder
     *
     * @return Term|HasMany
     */
    public function terms()
    {
        return $this->hasMany(Term::class);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
