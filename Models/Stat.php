<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;
    //stats of what player
    public function player(){
        return $this->belongsTo('App\Models\Player','player_id');    }
}
