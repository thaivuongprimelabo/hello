<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourcePhoneNumber extends Model
{
    //
    protected $table = "source_phone_numbers";
    protected $fillable = ['id', 'phone_number', 'author', 'description', 'deleted_at', 'created_at', 'updated_at'];
}
