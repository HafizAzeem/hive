<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class PackageMaster extends Model
{
	protected $guarded = ['id'];
	protected $table = 'packages';
	function room_type()
	{
		return $this->hasOne('App\RoomType','id','room_type_id');
   	}
	function meal_type()
	{
		return $this->hasOne('App\MealPlan','id','meal_plan_id');
   	}
}
