<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PhoneDestination extends Model
{
    //
    protected $table = 'phone_destinations';
    
    public static function getIncrementId() {
        $idMax = DB::table('phone_destinations')->max('id');
        return $idMax + 1;
    }
}
