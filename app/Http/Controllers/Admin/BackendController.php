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
use App\Models\SystemSetting;
use Validator;

class BackendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }


    public function index() {

    }

    public function monitoring(Request $request) {

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
            return view('admin.backend.monitoring.monitoring_ajax', $output);
        }
        
        return view('admin.backend.monitoring.monitoring', $output);
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
                    ->orderBy('all_start_time','desc')
                    ->paginate(config('master.ROW_PER_PAGE'));
        
        
        $paging = $calls->toArray();
        
        // Output to view
        $output = [
            'types'                 =>  Call::distinct()->get(['type']),
            'status'                =>  Call::distinct()->get(['status']),
            'source_phone_numbers'  =>  SourcePhoneNumber::distinct()->get(['phone_number']),
            'calls'                 =>  $calls,
            'dateFrom'              =>  $request->datefrom,
            'dateTo'                =>  $request->dateto,
            'paging'                =>  $paging
        ];
        
        return $output;
        
    }

    public function detail(Request $request) {
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
        return view('admin.backend.monitoring.monitoring_detail', $output);
    }

    public function users(Request $request)
    {
        $users = Users::paginate(10);
        return view('admin.backend.users.users', compact('users'));
    }

    public function usersEdit(Request $request)
    {
        $exitRow = false;
        if(!empty($request->id)) {
            $user = DB::table('users')->where(['id'=>$request->id])->first();
            if(!empty($user)) {
                $exitRow = true;
            }
        }

        if(!$exitRow) {
            return redirect('admin/users');
        }

        return view('admin.backend.users.users_edit',compact('user'));
    }

    public function usersNew(Request $request)
    {
        if($request->isMethod('post')) {
            $data = $request->all();
            $user = new Users();
            $user->name = $request->name;
            $user->loginid = $request->loginid;
            $user->password = \Hash::make($request->password);
            $user->save();
        }
        return view('admin.backend.users.users_new');
    }



    public function masters() {
        $sourcePhoneNumber = SourcePhoneNumber::paginate(10);
        return view('admin.backend.masters.masters',compact('sourcePhoneNumber'));
    }

    public function masterEdit(Request $request)
    {
        $exitRow = false;
        if(!empty($request->id)) {
            $sourcePhoneNumber = DB::table('source_phone_numbers')->where(['id'=>$request->id])->first();
            if(!empty($sourcePhoneNumber)) {
                $exitRow = true;
            }
        }

        if(!$exitRow) {
            return redirect('admin/masters');
        }

        return view('admin.backend.masters.masters_edit',compact('sourcePhoneNumber'));
    }

    public function masterNew()
    {
        return view('admin.backend.masters.masters_new');
    }

    public function settings(Request $request) {
        DB::enableQueryLog();
        $systemSettings = SystemSetting::find([config('master.SETTINGS_DEFAULT_ENTRY'), config('master.SETTINGS_DEFAULT_CALL_TIME')])
                          ->toArray();
        
        $output = [
            config('master.SETTINGS_DEFAULT_ENTRY')     => 0,
            config('master.SETTINGS_DEFAULT_CALL_TIME') => 0
        ];
        foreach($systemSettings as $system) {
            $output[$system['key']] = $system['value'];
        }
        
        
        if($request->isMethod('post')) {
            
            $messages = [
                'integer'       => '0～3の整数で入力してください。',
                'between'       => '{:min}～{:max}の整数で入力してください。',
            ];
            
            $validator = Validator::make($request->all(),[
                'retry'     =>  'integer|between:0,3',
                'call_time' =>  'integer|between:0,120'
            ], $messages);
            
            if(!$validator->fails()) {
                
                // Update retry
                DB::beginTransaction();
                try {
                    SystemSetting::updateOrCreate(
                            ['key'   => config('master.SETTINGS_DEFAULT_ENTRY')],
                            ['value' => $request->retry]
                        );
                    
                    SystemSetting::updateOrCreate(
                            ['key'   => config('master.SETTINGS_DEFAULT_CALL_TIME')],
                            ['value' => $request->call_time]
                        );
                    
                    DB::commit();
                    
                    return redirect(route('settings'))->with('success', __('messages.MSG_SETTING_SUCCESS'));
                    
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect(route('settings'))->with('error',  __('messages.MSG_SETTING_ERROR'));
                }
                
            } else {
                
                return redirect()->back()->withErrors($validator)->withInput();
                
            }
        }
        
        return view('admin.backend.settings.settings', compact('output'));
    }

}
