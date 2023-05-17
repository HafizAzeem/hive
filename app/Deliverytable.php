<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Deliverytable extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $table = 'customerfoodorders';

    protected $fillable = [
        'child_id','foodname','rate','quantity','mobile','customer_name','email','gst','pan','address','bulding_flat','delivery_no','landmark'
    ];

    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

}