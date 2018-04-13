<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use \App\Utils\Utils;

class LoginRegisterController extends Controller
{
  private $data = [];

  public function __construct() {
    $this->data['links'] = Utils::GetNavigation();
  }

  public function logout() {
    Utils::insertActivity('Has logged out');
    Auth::logout();

    return redirect('/');
  }

  public function login() {
    return view('pages.login',$this->data);
  }

  public function register() {
    return view('pages.register',$this->data);
  }

  public function loginUser(Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    if (Auth::attempt(['name' => $username, 'password' => $password])) {
      $request->session()->put('current_user',Auth::user());

      Utils::insertActivity('Has logged in');

      return redirect('/');
    }

    return redirect()->back()->with('error','Username or password is incorrect, try again!');
  }

  public function registerUser(Request $request) {
    $this->validate($request,[
      'username' => 'required|unique:users,name|min:5|max:15|regex:([a-zA-Z0-9.\?\!]+)',
      'password' => 'required|min:5|max:15',
      'confirmPassword' => 'required|same:password',
      'email' => 'required|unique:users,email|email'
    ]);

    $user = User::create([
      'name' => $request->input('username'),
      'password' => Hash::make($request->input('password')),
      'email' => $request->input('email'),
      'role_id' => 1
    ]);

    auth()->login($user);

    return redirect('/');
  }
}
