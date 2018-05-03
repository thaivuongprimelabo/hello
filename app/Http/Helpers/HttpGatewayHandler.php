<?php

namespace App\Helpers;

class HttpGatewayHandler {

    static $_apiUrl = "";
    static $_apiKey = "AC65e784efa6dcfdc3e98a8fe076158dda";
    static $_apiSecretKey = "862d6f19f41ecd596fc3fdd86f16ca7a";
    static $_clientID = "";
    static $_clientPassword = "";
    static $_auth_Username = "";
    static $_auth_Password = "";
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

    public static function setAuthUsername($AuthUsername) {
        return self::$_auth_Username = $AuthUsername;
    }

    public static function getAuthUsername() {
        return self::$_auth_Username;
    }

    public static function setAuthPassword($AuthPassword) {
        return self::$_auth_Password = $AuthPassword;
    }

    public static function getAuthPassword() {
        return self::$_auth_Password;
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

        $username = self::$_auth_Username;
        $password = self::$_auth_Password;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        if ($params) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        $header = array();
        $header[] = 'Content-type: application/json';

        // This should be the default Content-type for POST requests
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        if (curl_errno($ch) !== 0) {
            error_log('cURL error when connecting to ' . $url . ': ' . curl_error($ch));
        }

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close($ch);
        print_r($result);
    }

}
