<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class StockHistory extends Model
{
	protected $table = 'stock_history';
	protected $guarded = ['id'];
	protected $with = ['user','product'];
	function user(){
	 	return $this->hasOne('App\User','id','added_by');
	}
	function product(){
	 	return $this->hasOne('App\Product','id','product_id');
	}
}
