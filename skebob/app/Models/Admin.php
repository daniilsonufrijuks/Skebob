<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Brand;
use App\Models\Category;

class Admin extends Authenticatable
{
    protected $fillable = ['name', 'password'];
    protected $hidden = ['password'];
    protected $primaryKey = 'id';

    /**
     * Iegūt zīmolus, kuri pieder šim administratoram.
     */
    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class, 'admin_id');
    }

    /**
     * Iegūt kategorijas, kuras pieder šim administratoram.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, 'admin_id');
    }

    /**
     * Iegūt preces, kuras pieder šim administratoram.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'admin_id');
    }

}
