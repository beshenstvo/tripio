<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public function service() {
        return $this->belongsTo( Service::class, 'service_id');
    }

    protected $fillable = [
        'service_id',
        'client_phone',
        'client_name',
        'message',
        'archive'
    ];

    protected $table = 'requests';
}
