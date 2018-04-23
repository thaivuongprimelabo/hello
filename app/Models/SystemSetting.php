<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    //
    protected $table = 'system_settings';
    protected $fillable = ['key','value'];
    protected $primaryKey  = 'key';
    public $incrementing = false;
}
