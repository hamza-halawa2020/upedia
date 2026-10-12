<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOtpCode extends Model
{
    
    protected $table = 'user_otp_codes';

    protected $fillable = [
        'user_id',
        'token',
        'otp_code',
        'expired_time',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}


}
