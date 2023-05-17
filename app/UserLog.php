<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $guarded=['id'];
    function user_info(){
        return $this->hasOne('App\User','id','user_id');
    }
} 