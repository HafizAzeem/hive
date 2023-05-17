<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class PaymentMode extends Model
{
	protected $guarded = ['id'];
	protected $table = 'payment_mode';
}
