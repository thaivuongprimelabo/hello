<?php

namespace App\Helpers;

class Twilio {

    public static function getStatus($key = null) {
        $res = array(
            'WAITING' => 'WAITING',
            'TWILIO_CREATED' => 'TWILIO CREATED',
            'RINGING' => 'RINGING',
            'IN_PROGRESS' => 'IN PROGRESS',
            'FINISHED' => 'FINISHED',
            'TIMEOUT' => 'TIMEOUT',
            'CANCELED' => 'CANCELED',
            'FAILED' => 'FAILED',
            'TWILIO_FAILED' => 'TWILIO_FAILED'
        );
        if ($key) {
            return $res[$key];
        } else {
            return $res;
        }
    }

}
