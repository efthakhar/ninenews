<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    function index(Request $request) {

        $this->authorize('view-tags');
		
		$qs_perpage  = $request->query('perpage') ?? 10;
		$qs_name     = $request->query('name');
		$qs_slug     = $request->query('slug');
		$qs_sortby   = $request->query('sortby');
		$qs_sorttype = $request->query('sorttype') ?? 'asc';

		$tags = Tag::query();

		$tags->when($qs_name, function ($query, $qs_name ) {
			$query->where('name', 'LIKE', '%' . $qs_name . '%');
		})->when($qs_slug, function ($query, $qs_slug ) {
			$query->where('slug', 'LIKE', '%' . $qs_slug . '%');
		})->when($qs_sortby, function ($query, $qs_sortby) use ($qs_sorttype) {
			$query->orderby($qs_sortby, $qs_sorttype);
		}, function ($query) use ($qs_sorttype) {
			$query->orderBy('id', $qs_sorttype);
		});

        return response()->json([
			'tags'         => $tags->paginate($qs_perpage)->appends($request->query()),
			'sort_options' => [
				['label' => 'name', 'value' => 'name'],
				['label' => 'slug', 'value' => 'slug'],
			],
			'sort_type_options' => [
				['label' => 'asc', 'value' => 'asc'],
				['label' => 'desc', 'value' => 'desc'],
			],
		], 200);
    }
}
