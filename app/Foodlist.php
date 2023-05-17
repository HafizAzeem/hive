<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Foodlist extends Model
{
    // protected $guarded = ['id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'food_items';

    protected $fillable = [
        'name', 'price', 'description', 'food_image'
    ];
    
    
// 	function category(){
// 	 	return $this->hasOne('App\FoodCategory','id','category_id');
// 	}
    

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