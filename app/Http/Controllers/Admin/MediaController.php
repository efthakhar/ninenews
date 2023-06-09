<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MediaUploader;
use Plank\Mediable\Media;
use Throwable;

class MediaController extends Controller {

	public function index(Request $request) {

		$qs_name = $request->query('filename');

		$media_items = Media::inDirectory('public', 'media')
			->when($qs_name, function ($query, $qs_name ) {
				$query->where('filename', 'LIKE', '%' . $qs_name . '%');
			})
			->orderby('id','desc')
			->paginate(15)->appends($request->query());

		if ($request->ajax()) {

			$media  = [];
			foreach($media_items as $media_item){
				$media[] = [
					'id' => $media_item->id,
					'filename' => $media_item->filename,
					'url' => $media_item->getUrl(),
					'extension' => $media_item->extension,
					'size' => $media_item->size,
				];
			}
			return response()->json([
				'media' => $media,
				'last_page' => $media_items->lastPage(),
				'current_page' => $media_items->currentPage(),
			]);
		}

		return view('admin.media.index', [
			'media_items' => $media_items,
		]);
	}

	public function store(Request $request) {
        
		$uploaded_by = $request->user()->id;
		$uploaded_media = [];
		$validatedData = $request->validate([
			'mw_uploads'   => 'required',
			'mw_uploads.*' => 'mimes:csv,txt,xlx,xls,pdf,jpg,jpeg',
		]);
        
		foreach ($request->file('mw_uploads') as $file) {

			$fileName = str_replace('.' . $file->getClientOriginalExtension(), ' ', $file->getClientOriginalName());

			$uploaded_file = MediaUploader::fromSource($file)
				->toDirectory('media')
				->useFilename($fileName)
				->onDuplicateIncrement()
				->upload();

			$media = Media::find($uploaded_file->id);
			array_push($uploaded_media, [
				'url'      => $media->getUrl(),
				'id'       => $media->id,
				'filename' => $media->filename,
				'size'     => $media->size,
				'extension' => $media->extension,
			]);
		}

		return response()->json([
			'files'   => $uploaded_media,
		]);
	}

	public function delete($id) {
		try {
			$id = explode(',', $id);

			foreach ($id as $i) {
				Media::find($i)->delete();
			}
		} catch (Throwable $th) {
			return response()->json([
				'success' => false,
			], 500);
		}

		return response()->json([
			'success' => true,
		], 204);
	}
}
