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
use Illuminate\Support\Facades\Validator;
use App\Models\SystemSetting;
//use Validator;

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
        
        if($request->session()->has('condition')) {
            $string = $request->session()->get('condition');
            $condition = explode(',', $string);
            if($condition) {
                $request->type          = isset($condition[0]) ? $condition[0] : '';
                $request->call_number   = isset($condition[1]) ? $condition[1] : '';
                $request->status        = isset($condition[2]) ? $condition[2] : '';
                $request->datefrom      = isset($condition[3]) ? $condition[3] : '';
                $request->dateto        = isset($condition[4]) ? $condition[4] : '';
            }
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
        
        $output = [
            'source_phone_numbers'  =>  SourcePhoneNumber::distinct()->get(['phone_number']),
            'dateFrom'              =>  $request->datefrom,
            'dateTo'                =>  $request->dateto,
        ];
        
        $wheres = [
            [DB::raw('DATE(all_start_time)'), '>=', $request->datefrom],
            [DB::raw('DATE(all_start_time)'),'<=', $request->dateto]
        ];
        
        if(!empty($request->type)) {
            $wheres[]  = ['type', '=' , $request->type];
            $output['type'] = $request->type;
        }
        
        if(!empty($request->call_number)) {
            $wheres[]  = ['call_number', '=' , $request->call_number];
            $output['call_number'] = $request->call_number;
        }
        
        if(!empty($request->status)) {
            $wheres[]  = ['status', '=' , $request->status];
            $output['status'] = $request->status;
        }
        
        $calls = Call::where($wheres)
                    ->orderBy('all_start_time','desc')
                    ->paginate(config('master.ROW_PER_PAGE'));
        
        $paging = $calls->toArray();
        
        $output ['calls'] = $calls;
        $output ['paging'] = $paging;
        
        return $output;
        
    }
    
    public function back(Request $request) {
        $request->session()->flash('condition', $request->condition);
        return redirect()->route('monitoring');
    }
    
    public function detail(Request $request) {
        
        if($request->condition) {
            $request->session()->flash('condition', $request->condition);
            return redirect('admin/monitoring/detail/' . $request->id . '?_token='. $request->_token);
        }
        
        // Check token
        if ($request['_token'] != md5($request->id . __FUNCTION__ . csrf_token())) {
            return redirect()->route('monitoring');
        }
        
        $calls              = Call::find($request->id);
        
        // Get call's user
        $users  = $calls->User;
        $calls['loginid'] = $users['loginid'];
        
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
    
    public function updateMonitoring(Request $request) {
        return redirect(url()->full());
    }

    public function users(Request $request)
    {
        $users = Users::where('deleted_at',null)->paginate(10);
        return view('admin.backend.users.users', compact('users'));
    }

    public function coundLoginId(Request $request)
    {
        $loginid = $request->input('loginid');
        $count = DB::table('users')->where(['loginid'=>$loginid])->count();
        return ['count'=>$count];
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

        $message = ['info'=>[], 'pass'=>[]];
        if($request->isMethod('post')) {
            // edit info
            if($request->edittype == 'editinfo') {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:255',
                    'loginid' => 'required|max:255',
                ]);
                if (!empty($validator) && $validator->fails()) {
                    // fail
                    $message['info']['success'] = 0;
                    $message['info']['message'] = config('master.MESSAGE_NOTIFICATION.MSG_011');
                }
                else{
                    DB::table('users')
                        ->where('id', $request->id)
                        ->update([
                            'name' => $request->name,
                            'loginid' => $request->loginid,
                            'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                    $message['info']['success'] = 1;
                    $message['info']['message'] = config('master.MESSAGE_NOTIFICATION.MSG_019');
                }
            }
            // edit password
            elseif($request->edittype == 'editpass') {
                $validator = Validator::make($request->all(), [
                    'password' => 'required|min:8|max:255',
                ]);
                if (!empty($validator) && $validator->fails()) {
                    // fail
                    $message['pass']['success'] = 0;
                    $message['pass']['message'] = config('master.MESSAGE_NOTIFICATION.MSG_011');
                }
                else{
                    DB::table('users')
                        ->where('id', $request->id)
                        ->update([
                            'password' => \Hash::make($request->password),
                            'updated_at' => date('Y-m-d H:i:s'),
                          ]);
                    $message['pass']['success'] = 1;
                    $message['pass']['message'] = config('master.MESSAGE_NOTIFICATION.MSG_018');
                }
            }
            // delete user  -- remove
            /*elseif($request->edittype == 'deletetype') {
                DB::table('users')
                    ->where('id', $request->id)
                    ->update(['deleted_at'=>date('Y-m-d h:i:s')]);
                return redirect('admin/users');
            }*/
        }

        $user = DB::table('users')->where(['id'=>$request->id])->first();
        return view('admin.backend.users.users_edit',
                     compact('user'), compact('message')
                    )->with(['id'=>$request->id]);
    }

    public function lockUser(Request $request)
    {
        $count = DB::table('users')
                    ->where('id', $request->id)
                    ->update(['locked'=>$request->locked]);
        return [];
    }

    public function usersNew(Request $request)
    {
        $message = [];
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'loginid' => 'required|max:255',
                'password' => 'required|min:8|max:255',
            ]);
            if (!empty($validator) && $validator->fails()) {
                // fail
                $message['success'] = 0;
                $message['message'] = config('master.MESSAGE_NOTIFICATION.MSG_011');;
            }
            else{
                $count = DB::table('users')
                        ->where(['loginid'=>$request->loginid])
                        ->count();
                if(!$count) {
                    $user = new Users();
                    $user->id = Users::getIncrementId();
                    $user->name = $request->name;
                    $user->loginid = $request->loginid;
                    $user->password = \Hash::make($request->password);
                    $user->locked = 0;
                    $user->save();
                    $message['success'] = 1;
                    $message['message'] = $request->name . config('master.MESSAGE_NOTIFICATION.MSG_020');;
                }
            }

        }
        return view('admin.backend.users.users_new')->with('message',$message);
    }

    public function masters() {
        $sourcePhoneNumber = SourcePhoneNumber::where('deleted_at',null)->paginate(10);
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

        $message = [];
        if($request->isMethod('post')) {
            // edit info
            if($request->edittype == 'editinfo') {
                $validator = Validator::make($request->all(), [
                    'phone_number' => 'required|max:255',
                    'description' => 'required|max:255',
                ]);
                if (!empty($validator) && $validator->fails()) {
                    // fail
                    $message['success'] = 0;
                    $message['message'] = config('master.MESSAGE_NOTIFICATION.MSG_011');
                }
                else{
                    DB::table('source_phone_numbers')
                        ->where('id', $request->id)
                        ->update(['phone_number' => $request->phone_number, 'description' => $request->description]);
                    $message['success'] = 1;
                    $message['message'] = config('master.MESSAGE_NOTIFICATION.MSG_016');
                }
            }
            // delete user
            elseif($request->edittype == 'dell_phone_number') {
                DB::table('source_phone_numbers')
                    ->where('id', $request->id)
                    ->update(['deleted_at'=>date('Y-m-d h:i:s')]);
                return redirect('admin/masters');
            }
        }

        $sourcePhoneNumber = DB::table('source_phone_numbers')->where(['id'=>$request->id])->first();

        return view('admin.backend.masters.masters_edit',
                    compact('sourcePhoneNumber'), compact('message')
            );
    }

    public function masterNew(Request $request)
    {
        $message = [];
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'phone_number' => 'required|max:255',
                'description' => 'required|max:255',
            ]);
            if (!empty($validator) && $validator->fails()) {
                // fail
                $message['success'] = 0;
                $message['message'] = config('master.MESSAGE_NOTIFICATION.MSG_011');
            }
            else{
                try{
                    $count = DB::table('source_phone_numbers')
                        ->where(['phone_number'=>$request->phone_number])
                        ->count();
                    if(!$count) {
                        $phoneNumber = new SourcePhoneNumber();
                        $phoneNumber->phone_number = $request->phone_number;
                        $phoneNumber->description = $request->description;
                        $phoneNumber->save();
                        $message['success'] = 1;
                        $message['message'] = $request->phone_number . config('master.MESSAGE_NOTIFICATION.MSG_020');
                    }
                }
                catch (\Exception $e){
                    $message['success'] = 0;
                    $message['message'] = config('master.MESSAGE_NOTIFICATION.MSG_011');
                }
            }
        }
        return view('admin.backend.masters.masters_new',compact('message'));
    }

    public function countPhoneNumber(Request $request)
    {
        $count = DB::table('source_phone_numbers')
                    ->where(['phone_number'=>$request->phone_number])->count();
        return ['count'=>$count];
    }

    public function settings(Request $request) {
        $systemSettings = SystemSetting::find([config('master.SETTINGS.DEFAULT_RETRY'), config('master.SETTINGS.DEFAULT_CALL_TIME')])
                          ->toArray();
        
        $output = [
            config('master.SETTINGS.DEFAULT_RETRY')     => 0,
            config('master.SETTINGS.DEFAULT_CALL_TIME') => 0
        ];
        foreach($systemSettings as $system) {
            $output[$system['key']] = $system['value'];
        }
        
        if($request->isMethod('post')) {
            
            $messages = [
                'between'       => __('messages.MSG_SETTING_VALIDATE'),
            ];
            
            $validator = Validator::make($request->all(),[
                'retry'     =>  'integer|between:' . config('master.SETTINGS.RETRY_MIN') . ',' . config('master.SETTINGS.RETRY_MAX'),
                'call_time' =>  'integer|between:' . config('master.SETTINGS.CALL_TIME_MIN') . ',' . config('master.SETTINGS.CALL_TIME_MAX')
            ], $messages);
            
            if(!$validator->fails()) {
                
                // Update retry
                DB::beginTransaction();
                try {
                    SystemSetting::updateOrCreate(
                            ['key'   => config('master.SETTINGS.DEFAULT_RETRY')],
                            ['value' => $request->retry]
                        );
                    
                    SystemSetting::updateOrCreate(
                            ['key'   => config('master.SETTINGS.DEFAULT_CALL_TIME')],
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
