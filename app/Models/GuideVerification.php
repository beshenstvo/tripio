<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideVerification extends Model
{
    use HasFactory;

    protected $table = 'guide_verification';

    protected $fillable = [
        'user_id',
        'is_verified',
        'photo_certificate',
        'photo_passport',
        'photo_passport_with_selfie',
        'message_about_not_verified'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
