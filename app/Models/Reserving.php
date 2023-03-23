<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserving extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'room_id',
        'type_food',
        'arrival_time',
        'departure_time'
    ];

    protected $table = 'reserving';
}
