<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admins extends Authenticatable
{
    protected $fillable = ['name', 'password'];
    protected $hidden = ['password'];
    protected $primaryKey = 'id'; // or your actual primary key column name

    public function books(): HasMany
    {
        return $this->hasMany(Books::class, 'admin_id');
    }
}
