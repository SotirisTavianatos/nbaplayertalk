<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Player extends Model
{
    use HasFactory;
    public function hisstats()
    {
        return $this->hasOne('App\Models\Stat','player_id');   
    }

    public function commentsfor(){
        return $this->hasMany('App\Models\Comment','player_id');    
    }

    public function playedfor(){
        return $this->belongsToMany('App\Models\Team');    
    }

    public function currentteam($idplayer){
        $teamid=DB::table('player_team')->where('player_id', $idplayer)->where('until','1901')->value('team_id');
        return DB::table('teams')->where('id',$teamid)->value('name');
    }

}
