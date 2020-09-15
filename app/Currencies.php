<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
     protected $fillable = ['id',	'name',	'english_name',	'alphabetic_code',	'digit_code',	'rate'];
     public $timestamps = false;
}