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

		return view('admin.media.index', [
			'media_items' => Media::inDirectory('public', 'media')
				->when($qs_name, function ($query, $qs_name ) {
					$query->where('filename', 'LIKE', '%' . $qs_name . '%');
				})
				->paginate(4)->appends($request->query()),
		]);
	}

	public function store(Request $request) {
		$uploaded_by = $request->user()->id;

		$uploaded_media = [];

		$validatedData = $request->validate([
			'files'   => 'required',
			'files.*' => 'mimes:csv,txt,xlx,xls,pdf,jpg,jpeg',
		]);

		if ($request->TotalFiles > 0) {
			for ($x = 0; $x < $request->TotalFiles; ++$x) {
				if ($request->hasFile('files' . $x)) {
					$file     = $request->file('files' . $x);
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
					]);
				}
			}

			return response()->json([
				// 'success'=>'Ajax Multiple fIle has been uploaded',
				'files' => $uploaded_media,
			]);
		}

		return response()->json([
			'message' => 'Please try again.',
			'success' => false,
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
