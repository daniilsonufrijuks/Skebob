<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items';

    /**
     * Masveidā piešķiramie atribūti.
     */
    protected $fillable = [
        'quantity',
        'unit_price',
        'subtotal',
        'order_id',
        'product_id',
    ];

    /**
     * Iegūt pasūtījumu, kurai ir šis pasūtījuma rinda
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Orders::class);
    }

    /**
     * Iegūt preci, kas pieder šai pasūtījuma rindai
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class);
    }
}
