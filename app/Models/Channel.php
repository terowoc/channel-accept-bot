<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'chat_id',
        'username',
        'user_chat_id',
    ];

    public static function requests($chat_id)
    {
        return $this->all()->where('chat_id', $chat_id);
    }
}
