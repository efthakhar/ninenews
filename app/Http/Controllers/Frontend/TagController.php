<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller {

	public function index(Request $request) {
		return $request->route('lang', config('app.locale'));
	}
}
