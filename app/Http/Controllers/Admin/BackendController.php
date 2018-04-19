<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View;
use Illuminate\Support\Facades\Route;
use App\Models\Users;

class BackendController extends Controller {

    public function index() {
        
    }

    public function monitoring() {
        return view('admin.backend.monitoring');
    }

    public function detail() {
        return view('admin.backend.monitoring_detail');
    }

    public function users(Request $request) {

        $users = Users::paginate(5);

        if ($request->ajax()) {
            return view('admin.backend.users_ajax', compact('users'));
        }
        return view('admin.backend.users', compact('users'));
//        if ($request->ajax()) {
//            return Response::json(View::make('admin.backend.users_ajax', array('users' => $users))->render());
//        }
//        return View::make('admin.backend.users', array('users' => $users));
    }

    public function editUser($id, Request $request) {
        if (isset($id)) {
            if ($request['_token'] == md5($id . __FUNCTION__ . csrf_token())) {
                echo $id;
            } else {
                echo "die";
            }
        }
    }

    public function masters() {
        return view('admin.backend.masters');
    }

    public function settings() {
        return view('admin.backend.settings');
    }

}
