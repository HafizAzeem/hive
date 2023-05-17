<?php

namespace App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Transactions extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id', 'user_id','amount'
    ];
}