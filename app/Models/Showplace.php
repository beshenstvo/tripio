<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showplace extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_card_id',
        'type',
        'name',
        'description',
        'photo'
    ];
}
