<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function login(Request $request)
  {
    // Validate the input fields
    $credentials = $request->validate([
      'email' => ['required', 'string', 'email'],
      'password' => ['required', 'string'],
    ]);

    // Attempt to log the user in
    if (Auth::attempt($credentials, $request->remember)) {
      // Regenerate session to prevent session fixation attacks
      $request->session()->regenerate();

      // Redirect to the intended page (or a default page)
      return redirect()->intended('/app/academy/dashboard');
    }

    // If login fails, return back with an error message
    return back()->withErrors([
      'email' => 'The provided credentials do not match our records.',
    ]);
  }
}
