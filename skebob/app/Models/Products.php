<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    // Add these fields to the fillable array
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'category',
        'admin_id'
    ];

    public function orders()
    {
        return $this->belongsToMany(Orders::class, 'poincluded')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
