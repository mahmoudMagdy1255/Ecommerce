<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/*

 */
class Product extends Model {
	protected $table = 'products';

	protected $fillable = [
		'title',
		'content',
		'photo',
		'department_id',
		'trade_id',
		'manu_id',
		'color_id',
		'size_id',
		'weight_id',
		'currency_id',
		'start_at',
		'end_at',
		'start_offer_at',
		'end_offer_at',
		'price',
		'price_offer',
		'other_data',
		'weight',
		'stock',
		'status',
		'reason',
	];

	public function other_data() {
		return $this->hasMany('App\Model\OtherData', 'product_id', 'id');
	}

	public function malls() {
		return $this->hasMany('App\Model\MallProduct', 'product_id', 'id');
	}

	public function files() {
		return $this->hasMany('App\File', 'relation_id', 'id')->where('file_type', 'product');
	}
}
