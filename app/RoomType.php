<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class RoomType extends Model
{
	protected $guarded = ['id'];
	function rooms(){
	 	return $this->hasMany('App\Room','room_type_id','id')->orderBy('room_no');
	}
}
