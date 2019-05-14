<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductsDatatable;
use App\Http\Controllers\Controller;
use App\Model\MallProduct;
use App\Model\OtherData;
use App\Model\Product;
use App\Model\Size;
use App\Model\Weight;
use Illuminate\Http\Request;
use Storage;

class ProductsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(ProductsDatatable $ProductsDatatable) {
		return $ProductsDatatable->render('admin.products.index', ['title' => trans('admin.products')]);
	}

	public function prepare_weight_size() {
		if (request()->ajax() and request()->has('dep_id')) {

			$dep_arr = array_diff(explode(',', get_parent(request('dep_id'))), [request('dep_id')]);

			$sizes = Size::where('is_public', 'yes')->whereIn('department_id', $dep_arr)->orWhere('department_id', request('dep_id'))->pluck('name_' . lang(), 'id');

			$weights = Weight::pluck('name_' . lang(), 'id');

			return view('admin.products.ajax.size_weight', [
				'sizes' => $sizes,
				'weights' => $weights,
				'product' => Product::find(request('product_id')),
			])->render();

		} else {
			return 'برجاء ادخال القسم';
		}
	}

	public function upload_file($id) {

		if (request()->hasFile('file')) {
			$fid = upload([
				'file' => 'file',
				'path' => 'products/' . $id,
				'upload_type' => 'files',
				'file_type' => 'product',
				'relation_id' => $id,
			]);

			return response(['status' => true, 'id' => $fid], 200);
		}
	}

	public function update_product_image($id) {
		$product = Product::find($id);
		$product->update([
			'photo' => upload([
				'file' => 'file',
				'path' => 'products/' . $id,
				'upload_type' => 'single',
				'delete_file' => $product->photo,
			]),
		]);

		return response(['status' => true, 'photo' => $product->photo], 200);
	}

	public function delete_main_image($id) {
		$product = Product::find($id);
		Storage::delete($product->photo);
		$product->photo = null;
		$product->save();

	}

	public function delete_file() {

		if (request()->has('id')) {
			return delete(request('id'));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$product = Product::create([
			'title' => '',
		]);

		if ($product) {
			return redirect()->route('products.edit', $product->id);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$data = $this->validate(request(), [
			'country_name_ar' => 'required',
			'country_name_en' => 'required',
			'mob' => 'required',
			'code' => 'required',
			'logo' => 'required|' . v_image(),
		], [], [

			'country_name_ar' => trans('admin.country_name_ar'),
			'country_name_en' => trans('admin.country_name_en'),
			'mob' => trans('admin.mob'),
			'code' => trans('admin.code'),
			'logo' => trans('admin.country_flag'),
		]);

		if (request()->hasFile('logo')) {
			$data['logo'] = upload([
				'file' => 'logo',
				'path' => 'product',
				'upload_type' => 'single',
				'delete_file' => '',
			]);
		}

		Product::create($data);
		session()->flash('success', trans('admin.record_added'));
		return redirect(aurl('products'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$product = Product::find($id);

		return view('admin.products.product', ['title' => trans('admin.create_or_update_products', ['title' => $product->title]), 'product' => $product]);

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update($id) {

		$data = $this->validate(request(), [
			'title' => 'required',
			'content' => 'required',
			'department_id' => 'required|numeric',
			'trade_id' => 'required|numeric',
			'manu_id' => 'required|numeric',
			'color_id' => 'sometimes|nullable|numeric',
			'size' => 'sometimes|nullable',
			'size_id' => 'sometimes|nullable|numeric',
			'weight_id' => 'sometimes|nullable|numeric',
			'currency_id' => 'sometimes|nullable|numeric',
			'start_at' => 'required|date',
			'end_at' => 'required|date',
			'start_offer_at' => 'sometimes|nullable|date',
			'end_offer_at' => 'sometimes|nullable|date',
			'price' => 'required|numeric',
			'price_offer' => 'sometimes|nullable|numeric',
			'weight' => 'sometimes|nullable',
			'stock' => 'required|numeric',
			'status' => 'sometimes|nullable|in:pending,active,refused',
			'reason' => 'sometimes|nullable',
		], [], [

			'title' => trans('admin.title'),
			'content' => trans('admin.content'),
			'department_id' => trans('admin.department_id'),
			'trade_id' => trans('admin.trade_id'),
			'manu_id' => trans('admin.manu_id'),
			'color_id' => trans('admin.color_id'),
			'size' => trans('admin.size'),
			'size_id' => trans('admin.size_id'),
			'weight_id' => trans('admin.weight_id'),
			'currency_id' => trans('admin.currency_id'),
			'start_at' => trans('admin.start_at'),
			'end_at' => trans('admin.end_at'),
			'start_offer_at' => trans('admin.start_offer_at'),
			'end_offer_at' => trans('admin.end_offer_at'),
			'price' => trans('admin.price'),
			'price_offer' => trans('admin.price_offer'),
			'weight' => trans('admin.weight'),
			'stock' => trans('admin.stock'),
			'status' => trans('admin.status'),
			'reason' => trans('admin.reason'),
		]);

		if (request()->has('mall')) {

			MallProduct::where('product_id', $id)->delete();

			$i = 0;
			$other_data = '';

			foreach (request('mall') as $mall) {

				MallProduct::create([
					'product_id' => $id,
					'mall_id' => $mall,
				]);

				$i++;

			}

		}

		if (request()->has('input_key') and request()->has('input_value')) {

			OtherData::where('product_id', $id)->delete();

			$i = 0;
			$other_data = '';

			foreach (request('input_key') as $key) {

				OtherData::create([
					'product_id' => $id,
					'data_key' => $key,
					'data_value' => request('input_value')[$i] ?? '',
				]);

				$i++;

			}

		}

		Product::whereId($id)->update($data);

		return response(['status' => true, 'message' => trans('admin.updated_record')], 200);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$product = Product::find($id);

		Storage::delete($product->logo);

		$product->delete();

		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('products'));
	}

	public function multi_delete() {
		if (is_array(request('item'))) {

			foreach (request('item') as $id) {
				$product = Product::find($id);

				Storage::delete($product->logo);

				$product->delete();
			}

		} else {
			$product = Product::find(request('item'));

			Storage::delete($product->logo);

			$product->delete();
		}

		session()->flash('success', trans('admin.deleted_record'));
		return redirect(aurl('product'));
	}
}
