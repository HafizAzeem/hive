<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class MealPlan extends Model
{
	protected $guarded = ['id'];
	protected $table = 'meal_plans';
}
