<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite_route extends Model
{
    use HasFactory;

    public function route() {
        return $this->belongsTo(Ready_route::class, 'ready_routes_id');
    }

    protected $fillable = [
        'user_id',
        'ready_routes_id'
    ];

    protected $table = 'favorite_routes';
}
