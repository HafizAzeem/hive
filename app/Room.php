<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Room extends Model
{
	protected $guarded = ['id'];
	protected $with = ['room_type'];
	function room_type(){
	 	return $this->hasOne('App\RoomType','id','room_type_id');
	}
}
