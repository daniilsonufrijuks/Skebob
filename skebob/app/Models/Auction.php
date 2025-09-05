<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    // Add properties or relationships as needed
    protected $fillable = [
        'name',
        'description',
        'starting_bid',
        'img',
        'start_time',
        'end_time',
        'user_id',
    ];
}
