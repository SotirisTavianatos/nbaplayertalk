<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Player extends Model
{
    use HasFactory;
    //player's stats
    public function stats()
    {
        return $this->hasOne('App\Models\Stat','player_id');   
    }
    //comments about the player
    public function comments(){
        return $this->hasMany('App\Models\Comment','player_id');    
    }
    //player's teams
    public function teams(){
        return $this->belongsToMany('App\Models\Team');    
    }
    //player's current team
    public function currentteam(){
        return DB::table('player_team')->join('teams','team_id','=','player_team.team_id')->whereNull('until')->value('name');
    }

}
