<?php

declare(strict_types=1);

namespace App\Model\Admin;

use Hyperf\DbConnection\Model\Model;

/**
 * 
 */
class Role extends Model
{
    /**
     * The table associated with the model.
     */
    protected ?string $table = 'admin_roles';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'name', 'flag'
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected array $casts = [];
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'admin_roles_permissions', 'role_id', 'permission_id');
    }
}
