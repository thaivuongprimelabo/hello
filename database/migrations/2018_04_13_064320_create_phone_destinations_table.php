<?php

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
