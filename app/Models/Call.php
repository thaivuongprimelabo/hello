<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Call extends Model
{
    //
    protected $table = "calls";
    
    public function PhoneDestination() {
        return $this->hasMany('App\Models\PhoneDestination','call_id')->orderBy('id');
    }
    
    public function User() {
        return $this->belongsTo('App\Models\Users');
    }
    
    public static function getIncrementId() {
        $idMax = DB::table('calls')->max('id');
        return $idMax + 1;
    }
    
}
