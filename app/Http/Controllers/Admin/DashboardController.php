<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use View;

class DashboardController extends Controller
{
    public function index(){
        if (Auth::guest()) {
            return Redirect::to('/auth/login');
        } else {
            return View::make('admin.dashboard.index');
        }
    }
}
