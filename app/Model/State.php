<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    protected $fillable = [
           'state_name_ar',
           'state_name_en',
           'city_id',
           'country_id'
    ];

    public function country_id()
    {
    	return $this->hasOne(\App\Model\Country::class , 'id' , 'country_id');
    }

    public function city_id()
    {
      return $this->hasOne(\App\Model\City::class , 'id' , 'city_id');
    }
}
