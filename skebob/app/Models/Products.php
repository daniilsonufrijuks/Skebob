<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Admins;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
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
        'is_mystery_box',
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
        'is_mystery_box' => 'boolean',
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
            'is_mystery_box' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }


    /**
     * Iegūt administratoru, kam pieder produkts.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admins::class);
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
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

}
