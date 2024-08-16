<?php

declare(strict_types=1);

namespace App\Model;

use Hyperf\DbConnection\Model\Model;

/**
 */
class Game extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'games';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'name', 'status', 'created_at', 'created_user', 'updated_at', 'updated_user'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];

    public bool $timestamps = false;
}
