<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MysteryBoxItem extends Model
{
    use HasFactory;
    protected $table = 'mystery_box_items';

    /**
     * Masveidā piešķiramie atribūti.
     */
    protected $fillable = [
        'quantity',
        'mystery_box_id',
        'product_id'
    ];

    /**
     * Atribūti kas jānodod (cast).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Iegūt saistīto noslēpuma kastes (MysteryBox) ierakstu.
     */
    public function mysteryBox(): BelongsTo
    {
        return $this->belongsTo(MysteryBox::class, 'mystery_box_id', 'id');
    }

    /**
     * Iegūt preci, kas pieder šai kastes rindai.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
