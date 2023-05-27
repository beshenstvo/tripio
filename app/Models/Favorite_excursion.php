<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite_excursion extends Model
{
    use HasFactory;

    public function service() {
        return $this->belongsTo(Service::class, 'service_id');
    }

    protected $fillable = [
        'user_id',
        'service_id'
    ];

    protected $table = 'favorite_services';
}
