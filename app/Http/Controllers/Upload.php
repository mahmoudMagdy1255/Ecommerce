<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use App\File;

class Upload extends Controller
{

	public Static function delete($id)
	{
		$file = File::find($id);
		
		if ( $file ) {
			
			Storage::delete($file->full_path);

			$file->delete();
		}
	}

	public Static function Upload($data = [])
	{
		$new_name = array_has($data, 'new_name') ? $data['name'] : time();

		if (request()->hasFile($data['file']) && $data['upload_type']== 'single') {
			Storage::has($data['delete_file']) ? Storage::delete($data['delete_file']) : '';
			return request()->file($data['file'])->store($data['path']);

		}else if (request()->hasFile($data['file']) && $data['upload_type']== 'files') {

			$file = request()->file($data['file']);

			$file->store($data['path']);

			$add = File::create([
				'name' => $file->getClientOriginalName(),
		        'size' => $file->getSize(),
		        'file' => $file->hashName(),
		        'path' => $data['path'],
		        'full_path' => $data['path'] . '/' . $file->hashName(),
		        'mime_type' => $file->getMimeType(),
		        'file_type' => $data['file_type'],
		        'relation_id' => $data['relation_id'],
			]);

			return $add->id;
		}
	}
}
