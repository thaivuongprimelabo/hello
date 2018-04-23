<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    protected $table = 'users';

    public static function getIncrementId() {
        $idMax = DB::table('users')->max('id');
        return $idMax + 1;
    }
}
