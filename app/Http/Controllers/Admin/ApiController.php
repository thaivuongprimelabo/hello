<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Twilio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\HttpGatewayHandler;

class ApiController extends Controller {

    public function index() {
        
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
     * Xác thực user và phát hành key xác thực thông tin
     */
    public function myAuthenticate() {
        echo "My Authenticate.";
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
