<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Rules\CombineUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller {
	private $allDescendents = [];
	private $nested_cats    = [];

	public function index(Request $request) {
		$this->authorize('view-categories');

		$qs_language = $request->query('language');
		$qs_posttype = $request->query('posttype');
		$qs_perpage  = $request->query('perpage') ?? config('app.default_perpage');
		$qs_name     = $request->query('name');
		$qs_slug     = $request->query('slug');
		$qs_sortby   = $request->query('sortby');
		$qs_sorttype = $request->query('sorttype') ?? 'asc';

		$categories = Category::query();

		$categories
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

		return view('admin.category.index', [
			'categories' => $categories->withMedia()
				->with('parent_category:id,name')
				->with('sub_categories:parent_category_id,name')
				->paginate($qs_perpage)->appends($request->query()),
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

	public function list(Request $request) {
		$this->authorize('view-categories');

		$qs_language = $request->query('language');
		$qs_posttype = $request->query('posttype');

		// return [$qs_language,$qs_posttype];
		$categories = Category::where('lang', '=', $qs_language )->where('post_type', '=', $qs_posttype )->select(['id', 'name', 'parent_category_id'])->get();

		return response()->json($categories);
	}

	public function show($id) {
		$this->authorize('view-categories');
		
		return view('admin.category.single', [
			'category' => Category::find($id),
		]);
	}

	public function create() {
		$this->authorize('create-categories');

		return view('admin.category.create');
	}

	public function store(Request $request) {
		$this->authorize('create-categories');

		$slug = $request->slug ? strtolower(str_replace(' ', '-', $request->slug)) : strtolower(str_replace(' ', '-', $request->name));

		$request->merge(['slug' => $slug]);

		$validatedData = $request->validate([
			'lang'            => 'required',
			'post_type'       => 'required',
			'parent_category' => 'nullable',
			'name'            => [
				'required',
				'max:30',
				new CombineUnique(['lang' => $request->lang, 'name' => $request->name, 'post_type' => $request->post_type], 'categories', 'name must be unique'),
			],
			'slug' => [
				'required',
				'max:30',
				new CombineUnique(['lang' => $request->lang, 'name' => $request->name, 'post_type' => $request->post_type], 'categories', 'slug must be unique'),
			],
			'description'          => 'string|nullable',
			'meta_tag_description' => 'string|nullable',
			'meta_tag_keywords'    => 'string|nullable',
		]);

		$validatedData['created_by'] = auth()->id();

		$category                       = new Category();
		$category->parent_category_id   = $validatedData['parent_category'] ?? NULL;
		$category->name                 = $validatedData['name'];
		$category->slug                 = $validatedData['slug'];
		$category->description          = $validatedData['description'];
		$category->meta_tag_description = $validatedData['meta_tag_description'];
		$category->meta_tag_keywords    = $validatedData['meta_tag_keywords'];
		$category->lang                 = $validatedData['lang'];
		$category->post_type            = $validatedData['post_type'];

		$category->save();
		$category->attachMedia($request->category_thumbnail, 'thumbnail');

		return redirect()->route('admin.category.index');
	}

	public function edit($id) {
		$this->authorize('update-categories');

		return view('admin.category.edit', [
			'category' => Category::find($id),
		]);
	}

	public function update(Request $request, $id) {
		$this->authorize('view-categories');

		$slug = $request->slug ? strtolower(str_replace(' ', '-', $request->slug)) : strtolower(str_replace(' ', '-', $request->name));

		$request->merge(['slug' => $slug]);

		$validatedData = $request->validate([
			'lang'      => 'required',
			'post_type' => 'required',
			'name'      => [
				'required',
				'max:30',
				new CombineUnique(['lang' => $request->lang, 'name' => $request->name, 'post_type' => $request->post_type], 'categories', 'name must be unique', $id),
			],
			'slug' => [
				'required',
				'max:30',
				new CombineUnique(['lang' => $request->lang, 'name' => $request->name, 'post_type' => $request->post_type], 'tags', 'slug must be unique', $id),
			],
			'description'          => 'string|nullable',
			'meta_tag_description' => 'string|nullable',
			'meta_tag_keywords'    => 'string|nullable',
		]);

		$validatedData['updated_by'] = auth()->id();

		$category                       = Category::find($id);
		$category->parent_category_id   = $validatedData['parent_category'] ?? NULL;
		$category->name                 = $validatedData['name'];
		$category->slug                 = $validatedData['slug'];
		$category->description          = $validatedData['description'];
		$category->meta_tag_description = $validatedData['meta_tag_description'];
		$category->meta_tag_keywords    = $validatedData['meta_tag_keywords'];
		$category->lang                 = $validatedData['lang'];
		$category->post_type            = $validatedData['post_type'];

		$category->save();
		$category->detachMediaTags('thumbnail');
		$category->attachMedia($request->category_thumbnail, 'thumbnail');

		return redirect()->route('admin.category.edit', $id)->with('CategoryUpdateSuccess', 'Category Updated Successfully');
	}

	public function delete($id) {
		$id = explode(',', $id);
		$this->authorize('delete-categories');

		foreach ($id as $i) {
			$category = Category::find($i);
			$category->delete();
		}

		return response()->json(['message'=>'category deleted'],201);
	}

	public function getAllDescendentCats($id) {
		$subcats              = Category::where('parent_category_id', $id)->pluck('id')->toArray();
		$this->allDescendents = array_merge($this->allDescendents, $subcats);

		foreach ($subcats as $sc_id) {
			$this->getAllDescendentCats($sc_id);
		}
	}

	public function getParentableCats($lang, $post_type, $id) {
		$this->getAllDescendentCats($id);
		array_push($this->allDescendents, $id);

		return Category::whereNotIn('id', $this->allDescendents)
			->where('lang', $lang)
			->where('post_type', $post_type)
			->get();
	}
}
