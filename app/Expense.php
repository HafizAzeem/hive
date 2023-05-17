<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Expense extends Model
{
	protected $guarded = ['id'];
	function category(){
	 	return $this->hasOne('App\ExpenseCategory','id','category_id');
	}
	function attachments(){
	 	return $this->hasMany('App\MediaFile','tbl_id','id')->where('type','expenses');
	}
}
