<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use View;

class LoginController extends Controller {

    public function index() {
        if (Auth::guest()) {
            return Redirect::to('/auth/login');
        } else {
            return Redirect::to('/admin');
        }
    }

    public function login() {
        return View::make('admin.login.login');
    }

    public function checkLogin() {
        $rules = array(
            'loginid' => 'required|min:3',
            'password' => 'required|alphaNum|min:8|max:20'
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
            return Redirect::to('/auth/login')
                            ->withErrors($validator)
                            ->withInput();
        } else {

            $userdata = array(
                'loginid' => Input::get('loginid'),
                'password' => Input::get('password')
            );

            if (Auth::attempt($userdata)) {
                return Redirect::to('/admin');
            } else {
                return Redirect::to('/auth/login');
            }
        }
    }

    public function logout() {
        Auth::logout(); // log the user out of our application
        return Redirect::to('/auth/login');
    }

}
