<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller {


	public function showUserRegistrationPage() {
		if (Auth::check()) {
			return redirect('/admin/overview');
		}

		return view('auth.register');
	}

	public function registerUser (Request $request) {
		$request->validate([
			'name'     => ['required', 'string', 'max:255'],
			'email'    => ['required', 'email', 'max:255', 'unique:users'],
			'password' => ['required', Rules\Password::defaults()],
		]);

		$user = User::create([
			'name'     => $request->name,
			'email'    => $request->email,
			'password' => Hash::make($request->password),
		]);

		if ($user) {
			return redirect('/login');
		}

		return back();
	}

	public function showloginPage() {

		if (Auth::check()) {
			return redirect('/admin');
		}

		return view('auth.login');
	}

	public function login(Request $request) {

		$credentials = $request->validate([
			'email'    => 'required|email',
			'password' => 'required',
		]);

		if (Auth::attempt($credentials, 100)) {

			$request->session()->regenerate();

			return redirect('admin');
		}

		return back()->withErrors([
			'email'    => 'The email does not match',
			'password' => 'The password does not match',
		])->onlyInput('email', 'password');
	}

	public function logout(Request $request) {

		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();

		return redirect('/login');
	}
}
