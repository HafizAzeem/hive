<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Reservation extends Model
{
	protected $guarded = ['id'];
	protected $with = ['customer','room_type','id_cards'];
	function customer(){
	 	return $this->hasOne('App\Customer','id','customer_id');
	}
	function id_cards(){
	 	return $this->hasMany('App\MediaFile','tbl_id','id')->where('type','id_cards');
	}
	function room_type(){
	 	return $this->hasOne('App\RoomType','id','room_type_id');
	}
	function orders_items(){
	 	return $this->hasMany('App\OrderItem','reservation_id','id')->where('status','!=',4);
	}
	function orders_info(){
	 	return $this->hasOne('App\Order','reservation_id','id');
	}
	function persons(){
	 	return $this->hasMany('App\PersonList','reservation_id','id');
	}
	function meal_items(){
		return $this->hasOne('App\MealPlan','id','meal_plan');
   }
}
