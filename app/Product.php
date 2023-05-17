<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
	protected $guarded = ['id'];
	protected $with = ['unit'];
	function unit(){
	 	return $this->hasOne('App\Unit','id','measurement');
	}
}
