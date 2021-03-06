<?php

Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function () {

	Config::set('auht.defaults', 'admin');

	Route::get('login', 'AdminAuth@login');
	Route::post('login', 'AdminAuth@dologin');
	Route::get('forgot/password', 'AdminAuth@forgot_password');
	Route::post('forgot/password', 'AdminAuth@forgot_password_post');
	Route::get('reset/password/{token}', 'AdminAuth@reset_password');
	Route::post('reset/password/{token}', 'AdminAuth@reset_password_post');

	Route::group(['middleware' => 'admin:admin'], function () {

		Route::resource('admin', 'AdminController');
		Route::delete('admin/destroy/all', 'AdminController@multi_delete');

		Route::resource('users', 'UsersController');
		Route::delete('users/destroy/all', 'UsersController@multi_delete');

		Route::resource('countries', 'CountriesController');
		Route::delete('countries/destroy/all', 'CountriesController@multi_delete');

		Route::resource('cities', 'CitiesController');
		Route::delete('cities/destroy/all', 'CitiesController@multi_delete');

		Route::resource('states', 'StatesController');
		Route::delete('states/destroy/all', 'StatesController@multi_delete');

		Route::resource('departments', 'DepartmentsController');

		Route::resource('trademarks', 'TradeMarksController');
		Route::delete('trademarks/destroy/all', 'TradeMarksController@multi_delete');

		Route::resource('manufactures', 'ManufacturesController');
		Route::delete('manufactures/destroy/all', 'ManufacturesController@multi_delete');

		Route::resource('malls', 'MallsController');
		Route::delete('malls/destroy/all', 'MallsController@multi_delete');

		Route::resource('colors', 'ColorsController');
		Route::delete('colors/destroy/all', 'ColorsController@multi_delete');

		Route::resource('shippings', 'ShippingsController');
		Route::delete('shippings/destroy/all', 'ShippingsController@multi_delete');

		Route::resource('sizes', 'SizesController');
		Route::delete('sizes/destroy/all', 'SizesController@multi_delete');

		Route::resource('weights', 'WeightsController');
		Route::delete('weights/destroy/all', 'WeightsController@multi_delete');

		Route::resource('products', 'ProductsController');
		Route::delete('products/destroy/all', 'ProductsController@multi_delete');

		Route::post('upload/image/{pid}', 'ProductsController@upload_file');
		Route::post('delete/image', 'ProductsController@delete_file');
		Route::post('update/image/{pid}', 'ProductsController@update_product_image');
		Route::post('delete/product/image/{id}', 'ProductsController@delete_main_image');

		Route::post('/load/weight/size', 'ProductsController@prepare_weight_size');

		Route::get('/', function () {
			return view('admin.home');
		});

		Route::get('settings', 'Settings@setting');
		Route::post('settings', 'Settings@setting_save');
		Route::any('logout', 'AdminAuth@logout');

		Route::get('lang/{lang}', function ($lang) {
			session()->put('lang', $lang);
			return back();
		});
	});

});
