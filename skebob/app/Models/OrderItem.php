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
        'unit-price',
        'subtotal',
        'order_id',
        'product_id',
    ];

    /**
     * Atribūti kas jānodod (cast).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'unit-price' => 'decimal:2',
        'subtotal' => 'decimal:2',
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
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Iegūt pasūtījumu, kurai ir šis pasūtījuma rinda.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Iegūt preci, kas pieder šai pasūtījuma rindai.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Aprēķināt starpsummu (quantity * unit_price).
     */
    public function calculateSubtotal(): float
    {
        return $this->quantity * $this->unit_price;
    }

    /**
     * Atjauniniet starpsummu, pamatojoties uz pašreizējo quantity and unit_price.
     */
    public function updateSubtotal(): void
    {
        $this->update(['subtotal' => $this->calculateSubtotal()]);
    }
}
