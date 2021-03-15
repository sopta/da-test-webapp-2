<?php

declare(strict_types=1);

namespace CzechitasApp\Models;

use Carbon\Carbon;

/**
 * @property int        $id
 * @property string $title
 * @property string $content
 *
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 */
class News extends BaseModel
{
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
}
