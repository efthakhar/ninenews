<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {
    
	public function overview() {
		return view('admin.dashboard.overview');
	}
}
