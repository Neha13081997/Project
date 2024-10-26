<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'route_name',
        'type',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permission');
    }
}
