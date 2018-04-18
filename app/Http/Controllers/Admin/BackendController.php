<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;

class BackendController extends Controller
{
    public function index(){
        
    }
    
    public function monitoring(){
        return view('admin.backend.monitoring');
    }
    
    public function detail(){
        return view('admin.backend.monitoring_detail');
    }
    
    public function users(){
        return view('admin.backend.users');
    }
    
    public function masters(){
        return view('admin.backend.masters');
    }
    
    public function settings(){
        return view('admin.backend.settings');
    }
}
