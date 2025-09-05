<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    protected $table = 'goods_orders';

    protected $fillable = [
        'order_id',
        'order_number',
        'status',
        'name',
        'price',
        'description',
        'image',
        'category',
        'total_price',
        'shipping_address',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

}
