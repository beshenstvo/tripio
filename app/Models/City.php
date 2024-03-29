<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function routes() {
        return $this->hasMany(Ready_route::class, 'city_id');
    }

    protected $fillable = [
        'name'
    ];

    protected $table = 'cities';
}
