<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card_city extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_id',
        'name',
        'description',
        'photo'
    ];
    protected $table = 'city_card';
}
