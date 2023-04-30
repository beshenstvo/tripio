<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ready_route extends Model
{
    use HasFactory;

    public function cities() {
        return $this->belongsTo(City::class, 'city_id');
    }

    protected $fillable = [
        'city_id',
        'name',
        'description',
        'duration',
        'photo'
    ];

    protected $table = 'ready_routes';
}
