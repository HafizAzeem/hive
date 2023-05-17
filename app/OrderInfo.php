<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class OrderInfo extends Model
{
	protected $table = 'order_info';
	protected $guarded = ['id'];
}
