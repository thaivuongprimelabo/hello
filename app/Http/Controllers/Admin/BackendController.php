<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Users;
use View;
use App\Models\Call;
use App\Models\SourcePhoneNumber;
use App\Models\PhoneDestination;
class BackendController extends Controller {
    
    public function index() {
        if (Auth::guest()) { return Redirect::to('/auth/login');}
    }

    public function monitoring(Request $request) {
        if (Auth::guest()) { return Redirect::to('/auth/login');}
	
	    // From
        $date = new \DateTime(date('Y-m-d'));
        $interval = new \DateInterval('P1M');
        $date->sub($interval);
        
        if(empty($request->datefrom)) {
            $request->datefrom = $date->format('Y-m-d');
        }
        
        // To
        if(empty($request->dateto)) {
            $request->dateto   = date('Y-m-d');
        }
        
        $output = $this->doSearch($request);
        
        if ($request->ajax()) {
            return view('admin.backend.monitoring_ajax', $output);
        }
        
        return view('admin.backend.monitoring', $output);
    }
    
    public function ajaxSearch(Request $request) {
        echo $request->type;
        exit;
    }
    
    private function doSearch($request) {
        
        $wheres = [
            [DB::raw('DATE(all_start_time)'), '>=', $request->datefrom],
            [DB::raw('DATE(all_start_time)'),'<=', $request->dateto]
        ];
        
        if(!empty($request->type)) {
            $wheres[]  = ['type', '=' , $request->type];
        }
        
        if(!empty($request->call_number)) {
            $wheres[]  = ['call_number', '=' , $request->call_number];
        }
        
        if(!empty($request->status)) {
            $wheres[]  = ['status', '=' , $request->status];
        }
        
        $calls = Call::where($wheres)
                    ->orderBy(DB::raw('DATE(all_start_time)'),'DESC')
                    ->paginate(config('master.ROW_PER_PAGE'));
        
        
        $tmpInfo = $calls->toArray();
        
        // Output to view
        $output = [
            'types'                 =>  Call::distinct()->get(['type']),
            'status'                =>  Call::distinct()->get(['status']),
            'source_phone_numbers'  =>  SourcePhoneNumber::distinct()->get(['phone_number']),
            'calls'                 =>  $calls,
            'dateFrom'              =>  $request->datefrom,
            'dateTo'                =>  $request->dateto,
            'rowFrom'               =>  empty($tmpInfo['from']) ? 0 : $tmpInfo['from'],
            'rowTo'                 =>  empty($tmpInfo['to']) ? 0 : $tmpInfo['to'],
            'select_type'           =>  $request->type,
            'select_call'           =>  $request->call_number,
            'select_status'         =>  $request->status,
        ];
        
        return $output;
        
    }

    public function detail(Request $request) {
        if (Auth::guest()) { return Redirect::to('/auth/login');}
        
        // Check token
        if ($request['_token'] != md5($request->id . __FUNCTION__ . csrf_token())) {
            return redirect()->route('monitoring');
        }
        
        $calls              = Call::find($request->id);
        
        // If empty redirect to monitoring
        if(empty($calls)) {
            return redirect()->route('monitoring');
        }
        
        // Get phone_destination
        $phoneDestinations  = $calls->phoneDestination;
        
        
        $output = [
           'calls'              =>  $calls,
           'phoneDestinations'  =>  $phoneDestinations
        ];
        return view('admin.backend.monitoring_detail', $output);
    }

    public function users(Request $request) {
        if (Auth::guest()) { return Redirect::to('/auth/login');}

        $users = Users::paginate(1);

        if ($request->ajax()) {
            return view('admin.backend.users_ajax', compact('users'));
        }
        return view('admin.backend.users', compact('users'));
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
