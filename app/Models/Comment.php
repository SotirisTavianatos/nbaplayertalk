<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'player_id',
        'user_id',
    ];
    //who wrote the comment
    public function author()
    {
        return $this->belongsTo('App\Models\User','user_id');    
    }
    //about what player is this comment
    public function player()
    {
        return $this->belongsTo('App\Models\Player','player_id');    
    }
    //notifications of comment
    public function notification(){
        return $this->hasMany('App\Models\Notification','comment_id');    
    }

    //users that liked the comment
    public function likedby(){
        return $this->belongsToMany('App\Models\User');    
    }

        
}
