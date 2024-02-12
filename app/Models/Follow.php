<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id'];

    public function userSender(){
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function userReceiver(){
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
