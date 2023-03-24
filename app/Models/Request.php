<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'client_id',
        'client_phone',
        'client_name',
        'message'
    ];

    protected $table = 'requests';
}
