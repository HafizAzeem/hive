<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ExpenseCategory extends Model
{
	protected $guarded = ['id'];
	function expenses(){
	 	return $this->hasMany('App\Expense','category_id','id')->where('status',1);
	}
}
