<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Rules\CombineUnique;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller {
	public function index(Request $request) {
		$this->authorize('view-tags');

		$qs_language = $request->query('language');
		$qs_posttype = $request->query('posttype');
		$qs_perpage  = $request->query('perpage') ?? config('app.default_perpage');
		$qs_name     = $request->query('name');
		$qs_slug     = $request->query('slug');
		$qs_sortby   = $request->query('sortby');
		$qs_sorttype = $request->query('sorttype') ?? 'asc';

		$tags = Tag::query();

		$tags
			->when($qs_language, function ($query, $qs_language ) {
				$query->where('lang', '=', $qs_language );
			})
			->when($qs_posttype, function ($query, $qs_posttype ) {
				$query->where('post_type', '=', $qs_posttype );
			})
			->when($qs_name, function ($query, $qs_name ) {
				$query->where('name', 'LIKE', '%' . $qs_name . '%');
			})
			->when($qs_slug, function ($query, $qs_slug ) {
				$query->where('slug', 'LIKE', '%' . $qs_slug . '%');
			})->when($qs_sortby, function ($query, $qs_sortby) use ($qs_sorttype) {
				$query->orderby($qs_sortby, $qs_sorttype);
			}, function ($query) use ($qs_sorttype) {
				$query->orderBy('id', $qs_sorttype);
			});

		return view('admin.tag.index', [
			'tags'         => $tags->withMedia()->paginate($qs_perpage)->appends($request->query()),
			'sort_options' => [
				['label' => 'All', 'value' => ''],
				['label' => 'name', 'value' => 'name'],
				['label' => 'slug', 'value' => 'slug'],
			],
			'sort_type_options' => [
				['label' => 'All', 'value' => ''],
				['label' => 'asc', 'value' => 'asc'],
				['label' => 'desc', 'value' => 'desc'],
			],
		]);
	}

	public function show($id) {
		$this->authorize('view-tags');

		return view('admin.tag.single', [
			'tag' => Tag::with('media')->find($id),
		]);
	}

	public function create() {
		$this->authorize('create-tags');

		return view('admin.tag.create');
	}

	public function store(Request $request) {
		$this->authorize('create-tags');

		$slug = $request->slug ? strtolower(str_replace(' ', '-', $request->slug)) : strtolower(str_replace(' ', '-', $request->name));

		$request->merge(['slug' => $slug]);

		$validatedData = $request->validate([
			'lang'      => 'required',
			'post_type' => 'required',
			'name'      => [
				'required',
				'max:30',
				new CombineUnique(['lang' => $request->lang, 'name' => $request->name, 'post_type' => $request->post_type], 'tags', 'name must be unique'),
			],
			'slug' => [
				'required',
				'max:30',
				new CombineUnique(['lang' => $request->lang, 'name' => $request->name, 'post_type' => $request->post_type], 'tags', 'slug must be unique'),
			],
			'description'          => 'string|nullable',
			'meta_tag_description' => 'string|nullable',
			'meta_tag_keywords'    => 'string|nullable',
		]);

		$validatedData['created_by'] = auth()->id();


		$tag            = new Tag();
		$tag->name      = $validatedData['name'];
		$tag->slug      = $validatedData['slug'];
		$tag->description      = $validatedData['description'];
		$tag->meta_tag_description      = $validatedData['meta_tag_description'];
		$tag->meta_tag_keywords      = $validatedData['meta_tag_keywords'];
		$tag->lang      = $validatedData['lang'];
		$tag->post_type      = $validatedData['post_type'];
		
		$tag->save();
		$tag->attachMedia($request->tag_thumbnail, 'thumbnail');
		

		return redirect()->route('admin.tag.index');
	}

	public function edit($id) {
		$this->authorize('update-tags');

		return view('admin.tag.edit', [
			'tag' => Tag::find($id),
		]);
	}

	public function update(Request $request, $id) {
		$this->authorize('view-tags');

		$slug = $request->slug ? strtolower(str_replace(' ', '-', $request->slug)) : strtolower(str_replace(' ', '-', $request->name));

		$request->merge(['slug' => $slug]);

		$validatedData = $request->validate([
			'lang'                 => 'required',
			'post_type'            => 'required',
			'name'      => [
				'required',
				'max:30',
				new CombineUnique(['lang' => $request->lang, 'name' => $request->name, 'post_type' => $request->post_type], 'tags', 'name must be unique',$id),
			],
			'slug' => [
				'required',
				'max:30',
				new CombineUnique(['lang' => $request->lang, 'name' => $request->name, 'post_type' => $request->post_type], 'tags', 'slug must be unique',$id),
			],
			'description'          => 'string|nullable',
			'meta_tag_description' => 'string|nullable',
			'meta_tag_keywords'    => 'string|nullable',
		]);

		$validatedData['updated_by'] = auth()->id();

		//Tag::where('id', $id)->update($validatedData);
		$tag            = Tag::find($id);
		$tag->name      = $validatedData['name'];
		$tag->slug      = $validatedData['slug'];
		$tag->description      = $validatedData['description'];
		$tag->meta_tag_description      = $validatedData['meta_tag_description'];
		$tag->meta_tag_keywords      = $validatedData['meta_tag_keywords'];
		$tag->lang      = $validatedData['lang'];
		$tag->post_type      = $validatedData['post_type'];
		
		$tag->save();
		$tag->detachMediaTags('thumbnail');
		$tag->attachMedia($request->tag_thumbnail, 'thumbnail');

		return redirect()->route('admin.tag.edit', $id)->with('tagUpdateSuccess', 'Tag Updated Successfully');
	}

	public function delete($id) {
		$id = explode(',', $id);
		$this->authorize('delete-tags');

		foreach($id as $i){
			$tag = Tag::find($i);
			$tag->delete();
		}
		//Tag::whereIn('id', $id)->delete();
		return redirect()->back();
	}
}
