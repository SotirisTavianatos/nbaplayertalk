<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    //players that played with this team
    public function players(){
        return $this->belongsToMany('App\Models\Player');    
    }
}
