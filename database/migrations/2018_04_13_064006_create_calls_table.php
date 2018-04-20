<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->primary('id');
            $table->integer('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('content');
            $table->string('type')->comment('SAME_TIME|ORDER');
            $table->string('button_action',255);
            $table->string('call_number',32);
            $table->integer('call_time')->unsigned();
            $table->integer('current_trial')->unsigned();
            $table->integer('retry')->unsigned();
            $table->string('status',32);
            $table->timestamp('all_start_time')->useCurrent();
            $table->timestamp('all_end_time')->useCurrent();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        DB::table('calls')->insert(array('id' => 1,'user_id' => 1,'content' => '音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内音声内','button_action' => '閉じる','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-19 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 2,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-19 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 3,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'ORDER','all_start_time' => '2018-04-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 4,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 5,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'CANCELED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 6,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'TWILIO_CREATED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 7,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'RINGING', 'type' => 'SAME_TIME','all_start_time' => '2018-03-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 8,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'IN_PROGRESS', 'type' => 'SAME_TIME','all_start_time' => '2018-03-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 9,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-03-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 10,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-9999-9999','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'ORDER','all_start_time' => '2018-04-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 11,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-9999-9999','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 12,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-9999-99998','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 13,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-9999-9999','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'ORDER','all_start_time' => '2018-04-18 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 14,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-8888-9999','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-20 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 15,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-8888-9999','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-20 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 16,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-8888-9999','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-20 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 17,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-0000-0000','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-20 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 18,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-0000-0000','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'ORDER','all_start_time' => '2018-04-17 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 19,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-0000-0000','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'ORDER','all_start_time' => '2018-04-17 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 20,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-17 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 21,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-01 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 22,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-01 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 23,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-01 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        DB::table('calls')->insert(array('id' => 24,'user_id' => 1,'content' => '更新更新更新更新更新更新更新更新更新更新更新更新更新','button_action' => '更新','call_number' => '03-1234-5678','call_time' => 2, 'current_trial' => '1', 'retry' => 3, 'status' => 'FINISHED', 'type' => 'SAME_TIME','all_start_time' => '2018-04-01 10:56:20','all_end_time' => '2018-04-19 10:56:20'));
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calls');
    }
}
