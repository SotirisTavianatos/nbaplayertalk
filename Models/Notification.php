<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    //about what comment is this notification
    public function comment()
    {
        return $this->belongsTo('App\Models\Comment','comment_id');    

    }
    public function author()
    {
        return $this->belongsTo('App\Models\User','user_id');    
    }

}
