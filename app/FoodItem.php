<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class FoodItem extends Model
{
	protected $guarded = ['id'];
	function category(){
	 	return $this->hasOne('App\FoodCategory','id','category_id');
	}
}
