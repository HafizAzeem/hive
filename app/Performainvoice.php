<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Performainvoice extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id','name', 'mobile', 'title', 'check_in_date', 'check_out_date','duration_of_stay','payment_mode','room_type_id', 'no_of_rooms', 'payment', 'remarkone', 'amountone', 'remarktwo','amounttwo', 'remarkthree', 'amountthree', 'remarkfour', 'amountfour','remarkfive','amountfive'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
}
