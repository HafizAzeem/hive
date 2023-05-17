<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class FoodCategory extends Model
{
	protected $guarded = ['id'];
	function food_items(){
	 	return $this->hasMany('App\FoodItem','category_id','id')->where('status',1)->where('is_deleted',0)->orderBy('name','ASC');
	}
}
