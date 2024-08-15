<?php
declare(strict_types=1);

namespace App\Model\Admin;

use App\Model\Model;

class Log extends Model
{
    protected ?string $table = 'admin_logs';

    protected array $fillable = [
        'user_id', 'url', 'data', 'ip', 'created_at'
    ];

    public bool $timestamps = false;
}