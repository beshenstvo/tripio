<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_id',
        'user_id', # hotel owner
        'name',
        'stars',
        'location' 
    ];
}
