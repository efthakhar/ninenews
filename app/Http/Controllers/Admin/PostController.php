<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Rules\CombineUnique;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(Request $request) {
		$this->authorize('view-tags');

		$qs_language = $request->query('language');
		$qs_posttype = $request->query('posttype');
		$qs_perpage  = $request->query('perpage') ?? config('app.default_perpage');
		$qs_name     = $request->query('name');
		$qs_slug     = $request->query('slug');
		$qs_sortby   = $request->query('sortby');
		$qs_sorttype = $request->query('sorttype') ?? 'asc';

		$tags = Post::query();

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

}
