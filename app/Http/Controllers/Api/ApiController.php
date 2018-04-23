<?php

namespace App\Http\Controllers\Api;

use Twilio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\HttpGatewayHandler;
use DB;
use Hash;
use Carbon\Carbon;
use DateTime;

class ApiController extends Controller {

    public function index(Carbon $authdate) {
        die();
        $sid = HttpGatewayHandler::getApiKey();
        $token = HttpGatewayHandler::getApiSecretKey();
        $client = new Twilio($sid, $token);
        $number = $client->incomingPhoneNumbers->create(
                array(
                    "voiceUrl" => "http://demo.twilio.com/docs/voice.xml",
                    "phoneNumber" => "+15005550006"
                )
        );
        echo "Done";
    }

    /**
     * ユーザーを認証し、認証情報キーを発行する
     * @Function: myAuthenticate
     * @Date: 21-04-18
     */
    public function myAuthenticate(Request $request, Carbon $dt) {
        $id = isset($request->id) ? $request->id : 0;
        $password = isset($request->password) ? $request->password : '';

        $length = 64;
        $token = bin2hex(openssl_random_pseudo_bytes($length));

        $res = array();
        if ($id && $password) {
            $users = DB::table('users')->where(['loginid' => $id, 'password' => $password])->first();
            if ($users) {
                $ID = $users->id;
                #Insert record to `auth_keys` Table with user_id
                if (!$this->existsUserID($ID)) {
                    $LastID = DB::table('auth_keys')->latest()->first();
                    #有効期限(expired_at)は現在日時+1日とする。
                    $expired_at = $dt->now()->day($dt->day + 1);
                    DB::table('auth_keys')->insert(
                            ['id' => (isset($LastID) ? ($LastID->id) + 1 : 1), 'user_id' => $ID, 'auth_key' => $this->keyUnique($token, $length), 'expired_at' => $expired_at]
                    );
                }
                $Auth = DB::table('auth_keys')->where(['user_id' => $ID])->first();
                #"Now: " . $dt->toDateTimeString() . " Exp: " . $Auth->expired_at;
                if ($Auth && $dt->toDateTimeString() <= $Auth->expired_at) {
                    $res["key"] = $Auth->auth_key;
                    $res["result"] = true;
                    $res["message"] = "";
                } else {
                    $res["result"] = false;
                    $res["message"] = HttpGatewayHandler::getMsg('invalid_key');
                }
            } else {
                $res["result"] = false;
                $res["message"] = HttpGatewayHandler::getMsg('failed_authentication');
            }
        }

        return json_encode($res);
    }
    
    /**     
     * @Function: existsUserID
     * @Date: 21-04-18
     */
    public function existsUserID($id){
        $resultObj = DB::selectOne('select exists(select 1 from auth_keys where user_id=' . $id . ') as `exists`');
        if($resultObj->exists == 1){
            return true;
        } else {
            return false;
        }
    }
    /**     
     * @Function: keyUnique
     * @Date: 21-04-18
     */
    public function keyUnique($token, $length) {
        $resultObj = DB::selectOne('select exists(select 1 from auth_keys where auth_key="' . $token . '") as `exists`');
        if ($resultObj->exists == 1) {
            $token = bin2hex(openssl_random_pseudo_bytes($length));
        }
        return $token;
    }

    /**
     * Twilioによる電話番号発信のリクエストを受け取る
     * Nhận request của phát sóng số điện thoại bởi Twilio
     */
    public function callCreate() {
        echo "Call Create.";
    }

    /**
     * 音声通知を強制停止する
     * Dừng ép buộc thông báo giọng nói
     */
    public function callCancel() {
        echo "Call Cancel.";
    }

    /**
     * 音声通知状態を確認
     * Xác nhận trạng thái thông báo giọng nói
     */
    public function callStatus() {
        echo "Call Status.";
    }

    /**
     * 音声通知履歴を確認する
     * Xác nhận lịch sử thông báo giọng nói
     */
    public function callSearch() {
        echo "Call Search.";
    }

    /**
     * Twilioからのリクエストを受け取り、音声内容・ボタンアクション等をコントロールする。
     * Nhận request từ Twilio và control nội dụng giọng nói và button action...
     */
    public function twilioCall() {
        
    }

    /**
     * Twilioから通話状態遷移時の通話進行イベント(statusCallbackEvent)を受け取るためのAPI. 
     * API để nhận event tiến hành điện thoại khi di chuyển trạng thái điện thoại từ Twilio
     */
    public function twilioStatusEvent() {
        
    }

}
