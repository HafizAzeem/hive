<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Customerfoodorder extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $table = 'customerfoodorders';

    protected $fillable = [
        'name','quantity','unitprice','roomnumber', 'order_id', 'amount', 'payment_id', 'payment_done', 'order_date','mobile','otp'
    ];

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