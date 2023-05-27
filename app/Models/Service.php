<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function cities() {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function favorite_service() {
        return $this->hasMany(Favorite_excursion::class, 'service_id');
    }

    protected $fillable = [
        'city_id',
        'user_id',
        'name',
        'description',
        'duration',
        'photo',
        'price',
        'type',
        'kind'
    ];
}
