<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;

class Product extends Model
{
    use HasFactory;

    /**
     * Masveidā piešķiramie atribūti.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'price',
        'amount_value',
        'amount_unit',
        'country_origin',
        'image',
        'ingredients',
        'nutritional_info',
        'storage_conditions',
        'admin_id',
        'brand_id',
        'category_id',
    ];

    /**
     * Atribūti kas jānodod (cast).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'amount_value' => 'decimal:2',
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
            'price' => 'decimal:2',
            'amount_value' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }


    /**
     * Iegūt administratoru, kam pieder produkts.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Iegūt zīmolu, kam pieder produkts.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Iegūt kategoriju, kurai pieder produkts.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Iegūt pasūtījuma rindas, kurās ir šī prece.
     */
    public function items(): HasOneOrMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Iegūt saistīto noslēpuma kastes (MysteryBox) ierakstu (ieraksta var nebūt, ja prece nav noslēpuma kaste).
     */
    public function mysteryBox(): HasOne
    {
        return $this->hasOne(MysteryBox::class);
    }

    /**
     * Iegūt noslēpuma kastes rindas, kurās ir šī prece.
     */
    public function mysteryBoxItems(): HasOneOrMany
    {
        return $this->hasMany(MysteryBoxItem::class);
    }

}
