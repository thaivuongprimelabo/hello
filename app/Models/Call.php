<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    //
    protected $table = "calls";
    
    public function PhoneDestination() {
        return $this->hasMany('App\Models\PhoneDestination','call_id')->orderBy('id');
    }
    
}
