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
    public function commentedby()
    {
        return $this->belongsTo('App\Models\User','user_id');    
    }

    public function commentedfor()
    {
        return $this->belongsTo('App\Models\Player','player_id');    
    }

    public function notifyfor(){
        return $this->hasMany('App\Models\Notification','comment_id');    
    }

    public function likedby(){
        return $this->belongsToMany('App\Models\User');    
    }

        
}
