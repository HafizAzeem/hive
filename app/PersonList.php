<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class PersonList extends Model
{
	protected $guarded = ['id'];
	protected $table = 'person_lists';
}
