<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Books extends Model
{
    // Add properties or relationships as needed
    protected $fillable = [
        'name',
        'description',
        'file_path',
        'img',
        'admin_id',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admins::class, 'admin_id');
    }
}
