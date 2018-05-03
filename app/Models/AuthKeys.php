<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuthKeys extends Model {

    protected $table = 'auth_keys';

    public static function getIncrementId() {
        $idMax = DB::table('auth_keys')->max('id');
        return $idMax + 1;
    }

    public static function keyUnique($token = '', $length = 64) {
        $resultObj = DB::selectOne('select exists(select 1 from auth_keys where auth_key="' . $token . '") as `exists`');
        if ($resultObj->exists == 1) {
            $token = bin2hex(openssl_random_pseudo_bytes($length));
        }
        return $token;
    }

}
