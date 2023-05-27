<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller {

	public function index(Request $request) {

		$qs_perpage = $request->query('perpage') ?? 10;
		$qs_name    = $request->query('name');
		$qs_slug    = $request->query('slug');
		$qs_sortby  = $request->query('sortby');
		$qs_sorttype  = $request->query('sorttype')??'asc';

		$tags = Tag::query();

		$tags->when($qs_name, function ($query, $qs_name ) {
			$query->where('name', 'LIKE', '%' . $qs_name . '%');
		})->when($qs_slug, function ($query, $qs_slug ) {
			$query->where('slug', 'LIKE', '%' . $qs_slug . '%');
		})->when($qs_sortby, function ($query, $qs_sortby) use ($qs_sorttype) {
			$query->orderby($qs_sortby,$qs_sorttype);
		}, function ($query) use ($qs_sorttype){
			$query->orderBy('id',$qs_sorttype);
		});
		



		return view('admin.tag.index', [
			'tags' => $tags->paginate($qs_perpage)->appends($request->query()),
			'sort_options' => [
				['label'=>'name','value'=>'name'],
				['label'=>'slug','value'=>'slug']
			],
			'sort_type_options' => [
				['label'=>'asc','value'=>'asc'],
				['label'=>'desc','value'=>'desc']
			]
		]);
	}

	public function create() {
		return view('admin.tag.create');
	}

	public function store(Request $request) {
		$slug = $request->slug ? strtolower(str_replace(' ', '-', $request->slug)) : strtolower(str_replace(' ', '-', $request->name));

		$request->merge(['slug' => $slug]);

		$validatedData = $request->validate([
			'name'                 => 'required|unique:tags|max:30',
			'slug'                 => 'unique:tags|max:30',
			'description'          => 'string|nullable',
			'meta_tag_description' => 'string|nullable',
			'meta_tag_keywords'    => 'string|nullable',
		]);

		$validatedData['created_by'] = auth()->id();

		Tag::create($validatedData);

		return redirect()->route('admin.tag.index');
	}
}
