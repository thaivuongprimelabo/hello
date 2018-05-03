<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use DB;

class J001_Twilio implements ShouldQueue {

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request) {
        $this->request = $request;
    }

    /**
     * @Description: 音声発信リクエストに通知先IDを渡し、実行する。
     * @Job: J001_Twilio
     * @Params: Request
     * @return void
     * @File: A101 - 6.
     */
    public function handle() {

        $status = config('master.TWILIO_STATUS.FAILED');

        #POST Twilio API to GET $response.sid
        $response = true;
        $response_sid = '';

        #Verify Data
        $verifyData = false;

        if ($verifyData) {
            $status = config('master.TWILIO_STATUS.FAILED');
        } else if ($response) {
            $status = config('master.TWILIO_STATUS.TWILIO_CREATED');
        } else {
            $status = config('master.TWILIO_STATUS.TWILIO_FAILED');
        }
        
        #File: J001_Twilio (2.)
        if ($this->request['id']) {

            #Action: POST Parameters
            
            $ResponseData = [
                'id' => $this->request['id'],
                'call_id' => $this->request['call_id']
            ];
            
            #Action: Update
            #File: J001_Twilio (4.)
            $Update_PhoneDestinations = [
                'twilio_call_sid' => $response_sid,
                'status' => $status
            ];
            DB::table('phone_destinations')->where($ResponseData)->update($Update_PhoneDestinations);
        }
    }

}
