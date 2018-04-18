<?php

namespace App\Helpers;

class HttpGatewayHandler {

    static $_apiUrl = "";
    static $_apiKey = "AC7ab74e95bb637afb9ecae4259259ca58";
    static $_apiSecretKey = "d12233f4c5d39bf23a264e8c8edd462a";
    static $_clientID = "";
    static $_clientPassword = "";
    static $_content_type = "application/x-www-form-urlencoded";

    public static function setUrl($url) {
        return self::$_apiUrl = $url;
    }

    public static function getUrl() {
        return self::$_apiUrl;
    }

    public static function setApiKey($apiKey) {
        return self::$_apiKey = $apiKey;
    }

    public static function getApiKey() {
        return self::$_apiKey;
    }

    public static function setApiSecretKey($apiSecretKey) {
        return self::$_apiSecretKey = $apiSecretKey;
    }

    public static function getApiSecretKey() {
        return self::$_apiSecretKey;
    }

    public static function setClientID($clientID) {
        return self::$_clientID = $clientID;
    }

    public static function getClientID() {
        return self::$_clientID;
    }

    public static function setClientPassword($clientPassword) {
        return self::$_clientPassword = $clientPassword;
    }

    public static function getClientPassword() {
        return self::$_clientPassword;
    }

    public static function setContentType($content_type) {
        return self::$_content_type = $content_type;
    }

    public static function getContentType() {
        return self::$_content_type;
    }

    public function getContentAPI($url = "", $params = array()) {
        $url = self::$_apiUrl;

        $params = array(
        );

        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: ' . self::$_content_type,
                'content' => http_build_query($params),
                'timeout' => 60
            )
        ));

        $resp = file_get_contents($url, FALSE, $context);
        print_r($resp);
    }

    public function cURLContentAPI($url = "", $params = array(), $timeout = 60) {
        $url = self::$_apiUrl;
        $params = array(
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        // This should be the default Content-type for POST requests
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: " . self::$_content_type));

        $result = curl_exec($ch);
        if (curl_errno($ch) !== 0) {
            error_log('cURL error when connecting to ' . $url . ': ' . curl_error($ch));
        }

        curl_close($ch);
        print_r($result);
    }

    public function getMsg($key = null) {
        $res = array(
            'failed_authentication' => 'Failed Authentication',
            'call_is_already_finished' => 'Call is Already Finished',
            'call_is_in_progress' => 'Call is In-Progress',
            'invalid_request_parameter' => 'Invalid Request Parameter',
            'call_not_found' => 'Call not Found',
        );
        if ($key) {
            return $res[$key];
        } else {
            return $res;
        }
    }

}
