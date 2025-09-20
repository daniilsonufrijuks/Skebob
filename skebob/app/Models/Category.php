<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Admins;

class Category extends Model
{
    protected $table = 'categories';
    use HasFactory;

    /**
     * Masveidā piešķiramie atribūti.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'admin_id'
    ];

    /**
     * Atribūti kas jānodod (cast).
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Iegūt administratoru, kam pieder produkts.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admins::class);
    }

}
