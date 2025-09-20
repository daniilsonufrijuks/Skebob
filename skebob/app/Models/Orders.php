<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\OrderStatus;

class Orders extends Model
{
    use HasFactory;

    /**
     * Masveidā piešķiramie atribūti.
     */
    protected $fillable = [
        'user_id',
        'status',
        'total_price',
        'shipping_address',
        'ordered_at'
    ];

    /**
     * Atribūti kas jānodod (cast).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => OrderStatus::class,
        'total_price' => 'decimal:2',
        'ordered_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Iegūt atribūtus, kas jānodod (cast).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'total_price' => 'decimal:2',
            'ordered_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Iegūt lietotāju, kas izveidoja pasūtījumu.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Iegūt pasūtījuma rindas
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
