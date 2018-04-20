<?php

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
