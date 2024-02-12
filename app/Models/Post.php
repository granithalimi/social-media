<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Save;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'user_id'];

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function saves(){
        return $this->hasMany(Save::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
