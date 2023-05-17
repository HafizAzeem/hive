<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Callenderevent extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'arrivals';
    // protected $fillable = [
    //     'title', 'payment', 'payment_mode', 'remark', 'payment_date'
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
}
