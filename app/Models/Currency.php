<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['code', 'number', 'decimal', 'currency', 'currency_locations'];

    protected $casts = [
        'currency_locations' => 'array',
    ];
}