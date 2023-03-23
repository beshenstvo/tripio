<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'user_id',
        'name',
        'description',
        'duration',
        'price',
        'type',
        'kind'
    ];
}
