<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use View;

class DashboardController extends Controller
{
    public function index(){
        return View::make('admin.dashboard.index');
    }
}
