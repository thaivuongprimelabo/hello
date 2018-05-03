<?php

namespace App\Http\Controllers\Api;

use Twilio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use HttpGatewayHandler;
use TwilioHelper;
use DB;
use Hash;
use Carbon\Carbon;
use DateTime;
use App\Jobs\J001_Twilio;
use App\Models\Call;
use Twilio\Twiml;
use Twilio\Rest\Client;
use App\Models\ButtonAction;
use App\Models\PhoneDestination;
use App\Models\AuthKeys;

class ApiController extends Controller {

    protected $length = 64;
    protected $token = '';

    public function __construct() {
        $this->token = bin2hex(openssl_random_pseudo_bytes($this->length));
    }

    public function index(Carbon $dt) {
        // Your Account Sid and Auth Token from twilio.com/console
        $sid = "AC65e784efa6dcfdc3e98a8fe076158dda";
        $token = "862d6f19f41ecd596fc3fdd86f16ca7a";
        $twilio = new Client($sid, $token);
//        $calls = $twilio->calls->read();
// Loop over the list of calls and echo a property for each one
//                echo "<pre>";
//        var_dump($calls); exit();   
//
//        foreach ($calls as $call) {
//            echo $call->accountSid;
//        }
    }

    public function makeCall($phoneId) {
        $phone = DB::table('phone_destinations')
                ->where(['phone_destinations.id' => $phoneId])
                ->join('calls', 'phone_destinations.call_id', '=', 'calls.id')
                ->select('phone_destinations.id', 'phone_number', 'call_number')
                ->first();
        if (!empty($phone)) {
            $twilio = new \App\Helpers\Twilio();
            $respond = $twilio->makingCall($phone);

            if (isset($respond['sid'])) {
                $status = config('master.TWILIO_STATUS.TWILIO_CREATED');
                DB::table('phone_destinations')
                        ->where(['id' => $phoneId])
                        ->update(['status' => $status, 'twilio_call_sid' => $respond['sid']]);
            } elseif (isset($respond['code'])) {
                DB::table('phone_destinations')
                        ->where(['id' => $phoneId])
                        ->update(['status' => config('master.TWILIO_STATUS.FAILED')]);
            } else {
                DB::table('phone_destinations')
                        ->where(['id' => $phoneId])
                        ->update(['status' => config('master.TWILIO_STATUS.TWILIO_FAILED')]);
            }

//            echo "<pre>";
//            print_r($respond);
//            echo "<pre>";
        } else {
            echo 'phone number is not found';
        }
    }

    public function stopCall($phoneId) {
        $phone = DB::table('phone_destinations')
                ->where(['id' => $phoneId])
                ->select('id', 'twilio_call_sid', 'status')
                ->first();

        if (!empty($phone) && ($phone->status == 'TWILIO_CREATED' || $phone->status == 'RINGING')) {
            $twilio = new \App\Helpers\Twilio();
            $respond = $twilio->stopCall($phone);

            if (isset($respond['status'])) {
                if ($respond['status'] == 'completed') {
                    DB::table('phone_destinations')
                            ->where(['id' => $phoneId])
                            ->update([
                                'status' => config('master.TWILIO_STATUS.CANCELED'),
                                'end_time' => date('Y-m-d H:i:m'),
                                'call_time' => strtotime($respond['end_time']) - strtotime($respond['start_time']),
                    ]);
                } elseif ($respond['status'] == 'failed' || $respond['status'] == 'canceled') {
                    \Log::error('Data is not correct');
                }
            } else {
                \Log::error('Request to twilio fail');
            }

//            echo "<pre>";
//            print_r($respond);
//            echo "<pre>";
        }
    }

    /**
     * @Description: Valid GET Method
     * @Function: notfound
     * @Params:
     * @Result: Array
     * @Date: 21-04-18
     * @Modify:
     * @File:
     * @Author: ThanhBinh-Primelabo
     */
    public function notfound() {
        $result = array();
        $result['status'] = false;
        $result['message'] = "Error";
        return response()->json($result);
    }

    /**
     * @Description: ユーザーを認証し、認証情報キーを発行する
     * @Function: myAuthenticate
     * @Params: Request
     * @Result: JSON
     * @Date: 21-04-18
     * @Modify: 02-05-18
     * @File: A001_ユーザー認証
     * @Author: ThanhBinh-Primelabo
     */
    public function myAuthenticate(Request $request, Carbon $dt) {

        $id = isset($request->id) ? $request->id : 0;
        $password = isset($request->password) ? $request->password : '';

        $result = array();
        if (!($id && $password)) {
            $result["result"] = false;
            $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_002');
        } else {
            #A001 - 2.
            $Login_Condition = [
                'loginid' => $id,
                'locked' => 0
            ];
            $users = DB::table('users')->where($Login_Condition)->first();
            $chk = Hash::check($password, $users->password);
            if (!($users && $chk)) {
                $result["result"] = false;
                $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_001');
            } else {
                $ID = $users->id;
                #Insert record to `auth_keys` Table with user_id
                if (!$this->existsFieldWithValue('user_id', $ID, 'auth_keys')) {
                    #A001 - 3.1
                    $expired_at = $dt->now()->day($dt->day + 1);
                    $insert_auth_keys = [
                        'id' => AuthKeys::getIncrementId(),
                        'user_id' => $ID,
                        'auth_key' => AuthKeys::keyUnique($this->token, $this->length),
                        'expired_at' => $expired_at
                    ];
                    AuthKeys::insert($insert_auth_keys);
                }
                #A001 - 4.
                $Auth = AuthKeys::where(['user_id' => $ID])->first();
                if (!$this->verifyExpired($Auth->expired_at)) {
                    $result["key"] = $this->renewAuthKey($Auth->auth_key);
                } else {
                    $result["key"] = $Auth->auth_key;
                }
                $result["result"] = true;
                $result["message"] = "";
            }
        }
        return response()->json($result);
    }

    /**
     * @Description: Validate Expired
     * @Function: verifyExpired
     * @Params: (string) DateTime
     * @Result: boolean
     * @Date: 21-04-18
     * @Modify:
     * @Author: ThanhBinh-Primelabo
     */
    public function verifyExpired($expired_at) {
        $dt = new Carbon;
        if ($dt->toDateTimeString() <= $expired_at) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @Description: Renew Auth_key When Key Expired
     * @Function: renewAuthKey
     * @Params: (string) old auth_key
     * @Result: string
     * @Date: 21-04-18
     * @Modify:
     * @Author: ThanhBinh-Primelabo
     */
    public function renewAuthKey($auth_key) {
        $dt = new Carbon;
        #Renew auth_key
        $auth_key_new = $this->keyUnique($this->token, $this->length);
        $auth_keys = DB::table('auth_keys')->where('auth_key', $auth_key)->first();
        $UpdateAuthKeys = [
            'auth_key' => $auth_key_new,
            'expired_at' => $dt->day($dt->day + 1)->toDateTimeString(),
            'updated_at' => $dt->toDateTimeString()
        ];
        $UpdateAuthKeys_Condition = [
            'user_id' => $auth_keys->user_id
        ];
        DB::table('auth_keys')->where($UpdateAuthKeys_Condition)->update($UpdateAuthKeys);
        return $auth_key_new;
    }

    /**
     * @Description: Check Exists a record in Table
     * @Function: existsFieldWithValue
     * @Params: string $field, string $value, string $table
     * @Result: boolean
     * @Date: 21-04-18
     * @Modify:
     * @Author: ThanhBinh-Primelabo
     */
    public function existsFieldWithValue(string $field, string $value, string $table) {
        $resultObj = DB::selectOne(DB::raw('select exists(select 1 from ' . $table . ' where ' . $field . '=:value) as `exists`'), [
                    'value' => $value,
        ]);
        if ($resultObj->exists == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @Description: Unique Auth_key
     * @Function: keyUnique
     * @Params: (string) $old_token, (string) $length
     * @Result: (string) $newtoken
     * @Date: 21-04-18
     * @Modify:
     * @Author: ThanhBinh-Primelabo
     */
    public function keyUnique($token, $length) {
        $resultObj = DB::selectOne(DB::raw('select exists(select 1 from `auth_keys` where `auth_key`=:token) as `exists`'), [
                    'token' => $token,
        ]);
        if ($resultObj->exists == 1) {
            $token = bin2hex(openssl_random_pseudo_bytes($length));
        }
        return $token;
    }

    /**
     * @Description: Twilioによる電話番号発信のリクエストを受け取る
     * @Function: callCreate
     * @Params: Request Parameters
     * @Result: JSON
     * @Date: 21-04-18
     * @Modify: 02-05-18
     * @File: A101_音声通知リクエスト
     * @Author: ThanhBinh-Primelabo
     */
    public function callCreate(Request $request, Carbon $dt) {

        $target_list = isset($request->target_list) ? $request->target_list : '';
        $content = isset($request->content) ? $request->content : '';
        $auth_key = isset($request->key) ? $request->key : '';
        $button_action = isset($request->button_action) ? $request->button_action : '';
        $call_number = isset($request->call_number) ? $request->call_number : '';
        $call_time = isset($request->call_time) ? $request->call_time : 0;
        $retry = isset($request->retry) ? $request->retry : 0;
        $type = isset($request->type) ? $request->type : '';

        $type_arr = TwilioHelper::getTypes();

        $default_call_time = DB::table('system_settings')->select('value as default_call_time')->where('key', 'default_call_time')->first();
        $default_retry = DB::table('system_settings')->select('value as default_retry')->where('key', 'default_retry')->first();
        $settings = [
            'default_call_time' => $default_call_time->default_call_time,
            'default_retry' => $default_retry->default_retry
        ];

        $result = array();

        #GET user_id by auty_key & verify expired_at
        $Auth_keys = DB::table('auth_keys')->select('user_id', 'expired_at')->where('auth_key', $auth_key)->first();
        if ($Auth_keys && $this->verifyExpired($Auth_keys->expired_at)) {

            $target_list_arr = $this->validTargetList($target_list);
            if ($target_list_arr && $this->validContent($content) && $this->validCallTime($call_time) && $this->validRetry($retry)) {
                if ($this->existsFieldWithValue('phone_number', $call_number, 'source_phone_numbers')) {
                    DB::beginTransaction();
                    try {
                        #Insert Calls
                        $InsertCalls = array(
                            'user_id' => $Auth_keys->user_id,
                            'content' => $content,
                            'type' => (!in_array($type, array_keys($type_arr))) ? 'SAME_TIME' : $type,
                            'button_action' => '--',
                            'call_number' => $call_number,
                            'status' => TwilioHelper::getStatus('CALLING'),
                            'call_time' => ($call_time) ? $call_time : $settings['default_call_time'],
                            'current_trial' => 1,
                            'retry' => ($retry) ? $retry : $settings['default_retry'],
                            'all_start_time' => $dt->toDateTimeString()
                        );

                        $LastInsertID = Call::insertGetId($InsertCalls);

                        foreach ($target_list_arr as $target_key => $target_value) {
                            $Insert_Phone_Destinations = array(
                                'call_id' => $LastInsertID,
                                'order' => ($type == 'SAME_TIME') ? 0 : $target_key,
                                'phone_number' => $target_value,
                                'status' => TwilioHelper::getStatus('WAITING'),
                                'assigned' => '',
                                'trial' => ($retry == $settings['default_retry']) ? 1 : 0, //=1: when retry = default_retry
                            );
                            DB::table('phone_destinations')->insert($Insert_Phone_Destinations);
                        }


                        #Queue

                        $result['call_id'] = $LastInsertID;
                        $result['result'] = true;
                        $result['message'] = "";

                        /**
                         * @Description: キューを発行する (NOTE: キューの実行は別プロセス（バックグラウンド)で行う。)
                         * @Env: local - Test on localhost "File .env"
                         * @File: A101 - 6.
                         */
                        if (env('APP_ENV') == 'local') {

                            $calls = DB::table('calls')->select('type')->where('id', $LastInsertID)->first();

                            $type = ($calls) ? $calls->type : '';

                            #Start queue:listen --queue=J001_Twilio
                            $PDes = DB::table('phone_destinations')->select('id')->where('call_id', $LastInsertID)->get();
                            $PDes = collect($PDes)->map(function($x) {
                                        return (array) $x;
                                    })->toArray();

                            $PDes_Update = [
                                'status' => TwilioHelper::getStatus('CALLING'),
                                'start_time' => $dt->toDateTimeString()
                            ];

                            switch ($type) {
                                case 'SAME_TIME':
                                    if ($PDes) {
                                        foreach ($PDes as $Des) {
                                            $RequestData = [
                                                'id' => $Des['id'],
                                                'call_id' => $LastInsertID
                                            ];
                                            $job = (new J001_Twilio($RequestData))->onQueue('J001_Twilio');
                                            if (DB::table('phone_destinations')->where($RequestData)->update($PDes_Update)) {
                                                dispatch($job);
                                            }
                                        }
                                    }
                                    break;
                                case 'ORDER':
                                    foreach ($PDes as $Des) {
                                        $RequestData = [
                                            'id' => $Des['id'],
                                            'call_id' => $LastInsertID
                                        ];
                                        for ($i = 1; $i <= count($PDes); $i++) {
                                            $job = (new J001_Twilio($RequestData))->onQueue('J001_Twilio');
                                            if (DB::table('phone_destinations')->where($RequestData)->update($PDes_Update)) {
                                                dispatch($job);
                                            }
                                            $i++;
                                        }
                                    }
                                    break;
                            } #End queue
                            DB::commit();
                        } /* Close 6. */
                    } catch (\Exception $e) {
                        DB::rollback();
                        #something went wrong
                        $result['message'] = $e->getMessage();
                    }
                } else {
                    $result['result'] = false;
                    $result['message'] = config('master.MESSAGE_API_NOTIFICATION.MSG_003');
                }
            } else {
                $result['result'] = false;
                $result['message'] = config('master.MESSAGE_API_NOTIFICATION.MSG_004');
            }
        } else {
            $result["result"] = false;
            $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_002');
        }
        return response()->json($result);
    }

    /**
     * @Description:
     * @Function: validContent
     * @Params: (string) $content
     * @Result: boolean
     * @Date: 21-04-18
     * @Modify:
     * @File: A101 - Main Flow 3.
     * @Author: ThanhBinh-Primelabo
     */
    public function validContent(string $content) {
        if (4096 > strlen($content) && strlen($content) > 1) {
            return true;
        } else {
            return false;
        }
    }

    public function validButtonAction() {
        return true;
    }

    /**
     * @Description:
     * @Function: validCallTime
     * @Params: $number
     * @Result: boolean
     * @Date: 21-04-18
     * @Modify:
     * @File: A101 - Main Flow 3.
     * @Author: ThanhBinh-Primelabo
     */
    public function validCallTime($time) {
        if (is_numeric($time) && $time > 0 && $time < 600) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @Description:
     * @Function: validRetry
     * @Params: $number
     * @Result: boolean
     * @Date: 21-04-18
     * @Modify:
     * @File: A101 - Main Flow 3.
     * @Author: ThanhBinh-Primelabo
     */
    public function validRetry($retry) {
        if (is_numeric($retry) && $retry >= 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @Description:
     * @Function: validTargetList
     * @Params: (string) $string
     * @Result: Array List or false
     * @Date: 21-04-18
     * @Modify:
     * @File: A101 - Main Flow 3.
     * @Author: ThanhBinh-Primelabo
     */
    public function validTargetList($string) {
        if ($string != "") {
            $target_list_arr = array();
            $target_list = explode(",", $string);
            foreach ($target_list as $key => $item) {
                $target_list_arr[$key + 1] = $item;
            }
            if (count($target_list) >= 1) {
                return $target_list_arr;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @Description: 音声通知を強制停止する
     * @Function: callCancel
     * @Params: Request
     * @Result: JSON
     * @Date: 21-04-18
     * @Modify: 02-05-18
     * @File: A102
     * @Author: ThanhBinh-Primelabo
     */
    public function callCancel(Request $request) {

        $call_id = isset($request->call_id) ? $request->call_id : 0;
        $auth_key = isset($request->key) ? $request->key : '';

        $result = array();
        if (!($call_id && $auth_key)) {
            $result["result"] = false;
            $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_004');
        } else {
            $Auth_keys = DB::table('auth_keys')->select('user_id', 'expired_at')->where('auth_key', $auth_key)->first();
            if ($Auth_keys && $this->verifyExpired($Auth_keys->expired_at) && $this->existsFieldWithValue('id', $call_id, 'calls')) {
                $Calls = DB::table('calls')->where('id', $call_id)->first();
                if ($Calls) {
                    switch ($Calls->status) {
                        case 'FINISHED':
                        case 'CANCELED':
                            $result["result"] = false;
                            $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_005');
                            return response()->json($result);
                        case 'IN_PROGRESS':
                            $result["result"] = false;
                            $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_007');
                            return response()->json($result);
                    }
                }
                #5.6. Continue in Queue:
                #Start queue:listen --queue=J002_Twilio
                $result["result"] = true;
                $result["message"] = "";
            } else {
                $result["result"] = false;
                $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_002');
            }
        }
        return response()->json($result);
    }

    /**
     * @Description: 音声通知状態を確認
     * @Function: callStatus
     * @Params: Request
     * @Result: JSON
     * @Date: 21-04-18
     * @Modify:
     * @File: A103
     * @Author: ThanhBinh-Primelabo
     */
    public function callStatus(Request $request) {

        $call_id = isset($request->call_id) ? $request->call_id : 0;
        $auth_key = isset($request->key) ? $request->key : '';

        $result = array();
        if (!($call_id && $auth_key)) {
            $result["result"] = false;
            $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_004');
        } else {
            $Auth_keys = DB::table('auth_keys')->select('user_id', 'expired_at')->where('auth_key', $auth_key)->first();
            if ($Auth_keys && $this->verifyExpired($Auth_keys->expired_at) && $this->existsFieldWithValue('id', $call_id, 'calls')) {
                $result["result"] = true;
                $result["message"] = "";

                $Calls = DB::table('calls')->where('id', $call_id)->first();

                $WaitingCount = DB::table('phone_destinations')->where(['status' => 'WAITING', 'call_id' => $call_id])->get()->count();
                $RunningCount = DB::table('phone_destinations')->where(['status' => 'RUNNING', 'call_id' => $call_id])->get()->count();
                $SuccessCount = DB::table('phone_destinations')->where(['status' => 'SUCCESS', 'call_id' => $call_id])->get()->count();
                $FailureCount = DB::table('phone_destinations')->where(['status' => 'FAILED', 'call_id' => $call_id])->get()->count();

                $PhoneDestinations = DB::table('phone_destinations')->where('call_id', $call_id)->get();
                $PhoneDestinations = collect($PhoneDestinations)->map(function($x) {
                            return (array) $x;
                        })->toArray();

                if ($PhoneDestinations) {

                    $result['status_block'] = [
                        'call_id' => $call_id,
                        'call_number' => $Calls->call_number,
                        'status' => $Calls->status,
                        'waiting_count' => ($WaitingCount) ? $WaitingCount : 0,
                        'running_count' => ($RunningCount) ? $RunningCount : 0,
                        'success_count' => ($SuccessCount) ? $SuccessCount : 0,
                        'failure_count' => ($FailureCount) ? $FailureCount : 0,
                        'all_start_time' => $Calls->all_start_time,
                        'all_end_time' => $Calls->all_end_time,
                    ];

                    foreach ($PhoneDestinations as $PhoneDestination) {
                        $result['detail_block'][] = [
                            'phone_number' => $PhoneDestination['phone_number'],
                            'status' => $PhoneDestination['status'],
                            'twilio_status' => '',
                            'start_time' => $PhoneDestination['start_time'],
                            'end_time' => $PhoneDestination['end_time'],
                            'call_time' => $PhoneDestination['call_time'],
                            'push_botton' => $PhoneDestination['push_button'],
                            'message' => '',
                        ];
                    }
                } else {
                    $result["result"] = false;
                    $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_006');
                }
            } else {
                $result["result"] = false;
                $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_002');
            }
        }
        return response()->json($result);
    }

    /**
     * @Description: 音声通知履歴を確認する
     * @Function: callSearch
     * @Params: Request
     * @Result: JSON
     * @Date: 21-04-18
     * @Modify:
     * @File: A104
     * @Author: ThanhBinh-Primelabo
     */
    public function callSearch() {
        $call_id = isset($request->call_id) ? $request->call_id : 0;
        $phone_number = isset($request->phone_number) ? $request->phone_number : '';
        $start_time = isset($request->start_time) ? $request->start_time : '';
        $end_time = isset($request->end_time) ? $request->end_time : '';
        $auth_key = isset($request->key) ? $request->key : '';

        $result = array();
        $Auth_keys = DB::table('auth_keys')->select('user_id', 'expired_at')->where('auth_key', $auth_key)->first();
        if ($Auth_keys && $this->verifyExpired($Auth_keys->expired_at) && $this->existsFieldWithValue('id', $call_id, 'calls')) {
            # 内容要相談 - Wait
        } else {
            $result["result"] = false;
            $result["message"] = config('master.MESSAGE_API_NOTIFICATION.MSG_002');
        }
        return response()->json($result);
    }

    /**
     * Twilioからのリクエストを受け取り、音声内容・ボタンアクション等をコントロールする。
     * Nhận request từ Twilio và control nội dụng giọng nói và button action...
     */
    public function twilioCallTest() {
        $cnt = new HttpGatewayHandler();
        $cnt->setUrl('https://api.twilio.com/2010-04-01/Accounts/AC999655102e6299c3150c547a29745a19/Calls');
        $cnt->setAuthUsername('AC999655102e6299c3150c547a29745a19');
        $cnt->setAuthPassword('40e37e2ae4c6f63b08cbe7634ea4668c');
        header("Content-type: text/xml");
        $cnt->cURLContentAPI();
        die();
    }

    public function twilioCall(Request $request, Carbon $dt) {

        $id = $request->id ? $request->id : '';
        $twilio_call_sid = $request->CallSid ? $request->CallSid : '';
        $digits = $request->Digits ? $request->Digits : '';

        $result = [];
        // 2.システムはURLパラメータに含まれる{id}とリクエストパラメータのCallSidから対象の通知先(phone_destinations)を検索・取得する。
        $phoneDestination = PhoneDestination::where('id', $id)->first();

        // 3.親の音声通知リクエスト(calls)を以下の条件で取得する。
        $callId = $phoneDestination['call_id'];
        $calls = Call::where('id', $callId)->first();
        if (!$calls || $calls['status'] == 'FINISHED') {
            \Log::error($request);
            $result['status'] = 404;
            $result['message'] = 'The requested resource was not found';
            return response()->json($result);
        }

        if (empty($digits)) {

            // 通話内容を生成する。
            // <Say>
            $response = new Twiml();
            $response->say($calls['content']);

            // <Gather>
            $gather = $response->gather(['finishOnKey' => '#', 'timeout' => 120]);

            return $response;
        } else {
            $response = new Twiml();

            // 4.数字(Digits)が指定されたボタンアクションパターンのボタン組み合わせの中に存在するか検証する。
            $buttonPatern = ButtonAction::where('pattern', $digits)->first();
            if (!$buttonPatern) {
                $response->say("押下された数字は無効です。初めからやり直してください。");
                $response->redirect(url()->full(), ['method' => 'POST']);
                return $response;
            } else {
                // 5.数字(Digits)の値により処理を分岐する。
                switch ($digits) {
                    case 5:
                        $response->say("もう一度再生します。");
                        $response->redirect(url()->full(), ['method' => 'POST']);
                        return $response;
                        break;

                    default:
                        $phoneDestination = PhoneDestination::where('id', $id);
                        $data = $phoneDestination->first();
                        $start_time = $data['start_time'];
                        $current = Carbon::now();
                        $start_time = Carbon::createFromTimeString($start_time);
                        $seconds = $start_time->diffInSeconds($current);

                        // Update phone_destinations
                        $itemsUpdate = [
                            'push_button' => $digits,
                            'status' => 'FINISHED',
                            'end_time' => $current,
                            'call_time' => $seconds
                        ];

                        if ($digits == 1) {
                            $itemsUpdate['assigned'] = 'ASSIGNED';
                        }

                        $phoneDestination->update($itemsUpdate);

                        break;
                }

                if ($calls['type'] != 'SAME_TIME') {

                    // 6. 音声通知リクエスト(calls)のタイプ(type)が順番(ORDER)の場合、必要であれば次の通知先(phone_destination)へ発信を行う。
                    $phone_Destination = PhoneDestination::where('call_id', $callId)->where('status', 'WAITING')->orderBy('order')->first();
                    if ($phone_Destination) {

                        $requestData = [
                            'id' => $phone_Destination['id'],
                            'call_id' => $phone_Destination['call_id']
                        ];

                        // 上記で取得したレコード1件に対して電話発信キューを発行する。
                        $job = (new J001_Twilio($requestData))->onQueue('J001_Twilio');
                        dispatch($job);

                        // 発行すると同時に該当レコードを以下の通り更新する。
                        PhoneDestination::where($requestData)->update([
                            'status' => 'CALLING',
                            'start_time' => $dt->toDateTimeString()
                        ]);
                    }

                    // 7.1 3で取得した音声通知リクエスト(calls)に紐づく通知先(phone_destinations)を以下の条件で検索・取得する。
                    $countPhoneDestination = PhoneDestination::where('call_id', $callId)
                                    ->whereIn('status', ['WAITING', 'TWILIO_CREATED', 'RINGING', 'IN_PROGRESS'])
                                    ->where('trial', $calls['current_trial'])->get()->count();

                    switch ($countPhoneDestination) {
                        // 7.1.1.リトライ回数の判定を行う。
                        case 0:
                            if ($calls['retry'] <= ($calls['current_trial'] - 1)) {
                                $calls = Call::find($callId);
                                $calls->status = 'FINISHED';
                                $calls->save();
                            } else {
                                // 7.1.2.全ての通知先への電話が成功しているかを判定し、失敗があればリトライを行う。
                                $phoneNotFinish = PhoneDestination::where([['call_id', '=', $callId], ['status', '!=', 'FINISHED']]);
                                $countNotFinish = $phoneNotFinish->get()->count();

                                if ($countNotFinish == 0) {

                                    $calls = Call::find($id);
                                    $calls->status = 'FINISHED';
                                    $calls->save();
                                } else {
                                    // 7.1.3.リトライを開始する。
                                    // 7.1.4. 音声通知リクエスト(calls)の現在の試行回(current_trial)を1進める。以下の通り更新する。
                                    $calls = Call::find($callId);
                                    $currentTrial = $calls->current_trial + 1;

                                    $calls->current_trial = $currentTrial;
                                    $calls->save();

                                    // 7.1.5.phone_destinations.status = "FINISHED"以外になっているレコード全てに対してリトライを行う。
                                    $phoneNotFinish->update([
                                        'status' => 'WAITING',
                                        'assigned' => null,
                                        'trial' => $currentTrial,
                                        'start_time' => null,
                                        'end_time' => null,
                                        'call_time' => null,
                                        'push_button' => null
                                    ]);

                                    $phone_Destination = PhoneDestination::where('call_id', $callId)->where('status', 'WAITING')->orderBy('order')->first();
                                    if ($phone_Destination) {

                                        $requestData = [
                                            'id' => $phone_Destination['id'],
                                            'call_id' => $phone_Destination['call_id']
                                        ];

                                        // 上記で取得したレコード1件に対して電話発信キューを発行する。
                                        $job = (new J001_Twilio($requestData))->onQueue('J001_Twilio');
                                        dispatch($job);

                                        // 発行すると同時に該当レコードを以下の通り更新する。
                                        PhoneDestination::where($requestData)->update([
                                            'status' => 'CALLING',
                                            'start_time' => $dt->toDateTimeString()
                                        ]);
                                    }
                                }
                            }

                            break;
                        default:
                            break;
                    }
                }
            }
        }

        return response()->json();
    }

    /**
     * Twilioから通話状態遷移時の通話進行イベント(statusCallbackEvent)を受け取るためのAPI.
     * API để nhận event tiến hành điện thoại khi di chuyển trạng thái điện thoại từ Twilio
     */
    public function twilioStatusEvent(Request $request) {
        $id = $request->id;
        $twilio_call_sid = $request->CallSid;
        $status = $request->CallStatus;

        // 2. システムはURLパラメータに含まれる{id}とリクエストパラメータのCallSidから対象の通知先(phone_destinations)を検索・取得する。
        $phoneDestinations = PhoneDestination::where('id', $id);

        // 3. 状態(status)が以下のいづれかの場合、これはは最終の状態であるため更新を行わず終了する。
        $record = $phoneDestinations->first();
        if ($record['status'] == 'FAILED' || $record['status'] == 'TIMEOUT' ||
                $record['status'] == 'CANCELED' || $record['status'] == 'FINISHED' || $record['status'] == 'TWILIO_FAILED') {
            exit;
        }

        // 4. 状態(status)を更新する。
        $itemUpdate = [];
        switch ($status) {
            case 'ringing': // Twilioが通知先に電話をかけた
                $itemUpdate['status'] = 'RINGING';
                break;

            case 'in-progress': // 通知先が電話を取り通話中となった
                $itemUpdate['status'] = 'IN_PROGRESS';
                break;

            case 'busy': // 通知先が他と電話中のため出れなかった
                $itemUpdate['status'] = 'FAILED';
                $itemUpdate['end_time'] = Carbon::now();
                break;

            case 'no-answer': // 通知先が電話に出なかった
                $itemUpdate['status'] = 'TIMEOUT';
                $itemUpdate['end_time'] = Carbon::now();
                break;

            case 'failed': // 通知先に電話をかけることに失敗した。(主に対象の電話番号が存在しなかった場合)
                $itemUpdate['status'] = 'FAILED';
                $itemUpdate['end_time'] = Carbon::now();
                break;

            case 'canceled': // 通知先が電話に出る前にキャンセルされた
                $itemUpdate['status'] = 'CANCELED';
                $itemUpdate['end_time'] = Carbon::now();
                break;

            default:
                break;
        }

        // Update phone_destinations
        DB::beginTransaction();
        try {

            $phoneDestinations->update($itemUpdate);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return response()->json();
    }

    public static function getMsg($key = null, $lang = 'ja') {
        $res = array(
            'en' => array(
                'failed_authentication' => 'Failed Authentication',
                'invalid_key' => 'Invalid Key',
                'no_source_phone_number' => 'No source phone Number',
                'invalid_request_parameter' => 'Invalid Request Parameter',
                'call_is_already_finished' => 'Call is Already Finished',
                'call_not_found' => 'Call not Found',
                'call_is_in_progress' => 'Call is In-Progress',
            ),
            'ja' => array(
                'failed_authentication' => 'ログインIDまたはパスワードが違います。',
                'invalid_key' => '有効な認証情報キーではありません。',
                'no_source_phone_number' => '発信元番号が誤っています。',
                'invalid_request_parameter' => '値がただしくありません。',
                'call_is_already_finished' => '対象の音声通知はすでに終了しています。',
                'call_not_found' => '指定の音声通知は存在しません。',
                'call_is_in_progress' => '対象の音声通知は通話中のためキャンセルできません。',
            )
        );
        if ($key) {
            return $res[$lang][$key];
        } else {
            return $res;
        }
    }

}
