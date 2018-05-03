<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcePhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_phone_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone_number',32)->unique();
            $table->string('description',255);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        
        DB::table('source_phone_numbers')->insert(array('id' => 1,'phone_number' => '03-1234-5678','description' => 'TEST'));
        DB::table('source_phone_numbers')->insert(array('id' => 2,'phone_number' => '03-1122-2233','description' => 'TEST'));
        DB::table('source_phone_numbers')->insert(array('id' => 3,'phone_number' => '03-3344-4455','description' => 'TEST'));
        DB::table('source_phone_numbers')->insert(array('id' => 4,'phone_number' => '03-0000-0000','description' => 'TEST'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('source_phone_numbers');
    }
}
