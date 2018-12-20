<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Setting;
use Storage;

class Settings extends Controller {

	public function setting() {
		return view('admin.settings', ['title' => trans('admin.settings')]);
	}

	public function setting_save() {


		$data = $this->validate( request() , [
			'logo' => v_image(),
			'icon' => v_image(),
			'sitename_ar' => '',
			'sitename_en' => '',
			'email' => '',
			'description' => '',
			'keywords' => '',
			'main_lang' => '',
			'status' => '',
			'message_maintenance' => '',
		] , [] , [
			'logo' => trans('admin.logo'),
			'icon' => trans('admin.icon'),
		]);

		if ( request()->hasFile('logo') ) {

			$data['logo'] = upload([
				'file'     => 'logo',
				'path'     => 'settings',
				'upload_type' => 'single',
				'delete_file' => setting()->logo

			]);
		}

		if ( request()->hasFile('icon') ) {

			$data['icon'] = upload([
				'file'     => 'icon',
				'path'     => 'settings',
				'upload_type' => 'single',
				'delete_file' => setting()->icon

			]);
		}

		setting()->update($data);
		session()->flash('success', trans('admin.updated_record'));
		return redirect(aurl('settings'));
	}
}