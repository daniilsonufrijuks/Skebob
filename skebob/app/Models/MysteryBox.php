<?php

namespace App\Models;

use App\Enums\MysteryBoxCategory;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class MysteryBox extends Model
{
    use HasFactory;
    protected $table = 'mystery_boxes';

    /**
     * Masveidā piešķiramie atribūti.
     */
    protected $fillable = [
        'category',
        'description',
        'product_id'
    ];

    /**
     * Atribūti kas jānodod (cast).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => MysteryBoxCategory::class,
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
            'status' => MysteryBoxCategory::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Iegūt saistīto preces ierakstu (var nebūt, ja prece nav noslēpuma kaste).
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Iegūt noslēpuma kastes rindas.
     */
    public function mysteryBoxItems(): HasOneOrMany
    {
        return $this->hasMany(MysteryBoxItem::class);
    }

}
