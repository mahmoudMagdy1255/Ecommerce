<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Manufactures extends Model
{
	protected $table = 'manufactures';

	protected $fillable = [
        'name_ar',
        'name_en',
        'facebook',
        'twitter',
        'website',
        'contact_name',
        'email',
        'address',
        'mobile',
        'lat',
        'lng',
        'icon',
    ];
}
