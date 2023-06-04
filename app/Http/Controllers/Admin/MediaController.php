<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use MediaUploader;
use Plank\Mediable\Media ;

class MediaController extends Controller {

	public function index(Request $request) {
		return view('admin.media.index',[
			'media_items'=> Media::inDirectory('public','media')->paginate(10)
		]);
	}

	public function store(Request $request) {

		$uploaded_by    = $request->user()->id;

		$uploaded_media = [];
		
		$validatedData = $request->validate([
			'files' => 'required',
			'files.*' => 'mimes:csv,txt,xlx,xls,pdf,jpg,jpeg'
		]);
	 
		if($request->TotalFiles > 0)
		{
				
			for ($x = 0; $x < $request->TotalFiles; $x++) 
			{
	
				if ($request->hasFile('files'.$x)) 
				{
					$file      = $request->file('files'.$x);

					$uploaded_media_path = 
					MediaUploader::fromSource($file)
					->toDirectory('media')
					->useFilename($uploaded_by.time()."-".$file->getClientOriginalName())
					//->setMaximumSize(9999999)

					->upload();
					//
					//array_push($uploaded_media,$uploaded_media_path);
					
				}

			}
	
			return response()->json([
				'success'=>'Ajax Multiple fIle has been uploaded',
				'files' => $uploaded_media
			]);
	
			
		}
		else
		{
			return response()->json([
				"message" => "Please try again.",
				"success" => false,
				"files" => $uploaded_media,
			]);
		}

	}
	function delete($id) {

	   $id  = explode(',',$id);
	   // $id = Media::pluck('id');
	   foreach ($id as $i) {
		   Media::find($i)->delete();
	   }
	   return redirect()->back();

   }
}
