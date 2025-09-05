<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    protected $fillable = ['bid_amount', 'user_id', 'item_id'];
}
