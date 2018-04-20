<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Users;
use View;
use DB;

class BackendController extends Controller {
    
    public function index() {
        if (Auth::guest()) { return Redirect::to('/auth/login');}
    }

    public function monitoring() {
        if (Auth::guest()) { return Redirect::to('/auth/login');}
        return view('admin.backend.monitoring');
    }

    public function detail() {
        if (Auth::guest()) { return Redirect::to('/auth/login');}
        return view('admin.backend.monitoring_detail');
    }

    public function users(Request $request) {
//        $last = DB::table('users')->latest('id')->first();

        if (Auth::guest()) { return Redirect::to('/auth/login');}

        $users = Users::paginate(5);
        
        $paging = $users->toArray();

        if ($request->ajax()) {
            return view('admin.backend.users_ajax', compact('users','paging'));
        }
        return view('admin.backend.users', compact('users','paging'));
    }

    public function editUser($id, Request $request) {
        if (Auth::guest()) { return Redirect::to('/auth/login');}
        if (isset($id)) {
            if ($request['_token'] == md5($id . __FUNCTION__ . csrf_token())) {
                echo $id;
            } else {
                echo "die";
            }
        }
    }

    public function masters() {
        if (Auth::guest()) { return Redirect::to('/auth/login');}
        return view('admin.backend.masters');
    }

    public function settings() {
        if (Auth::guest()) { return Redirect::to('/auth/login');}
        return view('admin.backend.settings');
    }

}
