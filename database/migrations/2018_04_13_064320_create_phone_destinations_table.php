<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_destinations', function (Blueprint $table) {
            $table->primary('id');
            $table->integer('id')->unsigned();
            $table->integer('call_id')->unsigned();
            $table->string('twilio_call_sid',255);
            $table->integer('order')->unsigned();
            $table->string('phone_number',32);
            $table->string('status',32);
            $table->string('assigned',32)->nullable();
            $table->integer('trial')->unsigned();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('call_time')->nullable();
            $table->string('push_button',32)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('call_id')->references('id')->on('calls');
        });
        
        DB::table('phone_destinations')->insert(array('id' => 1,'call_id' => 1,'twilio_call_sid' => '99999999999','order' => 1, 'phone_number' => '03-5555-5555', 'status' => 'FINISHED', 'assigned' => 'TESTTTT', 'trial' => 9, 'call_time' => '10', 'push_button' => '更新'));
        DB::table('phone_destinations')->insert(array('id' => 2,'call_id' => 1,'twilio_call_sid' => '99999999999','order' => 1, 'phone_number' => '03-5555-6666', 'status' => 'FINISHED', 'assigned' => 'TESTTTT', 'trial' => 9, 'call_time' => '10', 'push_button' => '更新'));
        DB::table('phone_destinations')->insert(array('id' => 3,'call_id' => 1,'twilio_call_sid' => '99999999999','order' => 1, 'phone_number' => '03-5555-7777', 'status' => 'FINISHED', 'assigned' => 'TESTTTT', 'trial' => 9, 'call_time' => '10', 'push_button' => '更新'));
        DB::table('phone_destinations')->insert(array('id' => 4,'call_id' => 2,'twilio_call_sid' => '88888888888','order' => 1, 'phone_number' => '01-2345-6789', 'status' => 'CANCELED', 'assigned' => 'TESTTTT', 'trial' => 9, 'call_time' => '10', 'push_button' => '更新'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phone_destinations');
    }
}
