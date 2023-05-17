<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatePriceRange extends Model
{
    protected $guarded = 'id';
    protected $table = 'date_price_range';

    function room_type(){
        return $this->hasOne('App\RoomType','id','room_type_id');
    }
}
