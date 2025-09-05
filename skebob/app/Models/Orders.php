<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'items', 'status', 'total', 'ordered_at'];

    /**
     * Define the relationship to the User model.
     * This assumes 'user_id' is the foreign key.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function orderGoods(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderGoods::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Products::class, 'poincluded', 'order_id', 'product_id')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

}
