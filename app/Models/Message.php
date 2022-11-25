<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'conversation_id',
        'message',
        'message_type'
    ];
    public function user()
    {
        return $this->hasOne(User::class,'id','receiver_id');
    }
}
