<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AuthController as BaseAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAuthController
{
  public function getLogin()
  {
      if ($this->guard()->check()) {
          return redirect($this->redirectPath());
      }

      return view('admin.login');
  }
  
  public function username()
  {
    return 'email';
  }

  public function postLogin(Request $request)
  {
    $credentials = $request->only(['email', 'password']);
    /*
    $validator = Validator::make($credentials, [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return back()->withInput()->withErrors($validator);
    }
    */

    if (Auth::guard('admin')->attempt($credentials)) {
        admin_toastr(trans('admin.login_successful'));
        return redirect()->intended(config('admin.route.prefix'));
    }

    return back()->withInput()->withErrors(['email' => trans('auth.failed')]);
  }
  
}
