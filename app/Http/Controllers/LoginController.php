<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;
class LoginController extends Controller {
    public function adminLogin() {
        //set settings in session
        setSettings();
        if(Auth::check()){
            return redirect()->route('new-dashboard');
        }
        return view('backend/login');
    }
    public function doLogin(Request $request) {
        if (Auth::attempt(['email' => $request->username, 'password' => $request->password, 'status' => 1])) {
            return redirect()->route('new-dashboard')->with(['success' => config('constants.FLASH_SUCCESS_LOGIN')]);
        }
        return redirect()->back()->with(['error' => config('constants.FLASH_INVALID_CREDENTIAL')]);
    }
    public function logout(Request $request) {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
