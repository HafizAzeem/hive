<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
	protected $guarded = ['id'];
	protected $with = ['reservation_data','orders_items','order_history'];
	function reservation_data(){
	 	return $this->hasOne('App\Reservation','id','reservation_id');
	}
	function order_history(){
	 	return $this->hasMany('App\OrderHistory','order_id','id');
	}
	function last_order_history(){
	 	return $this->hasOne('App\OrderHistory','order_id','id')->orderBy('id','DESC');
	}
	function orders_items(){
	 	return $this->hasMany('App\OrderItem','order_id','id')->where('status','!=',4);
	}
}
