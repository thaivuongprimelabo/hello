<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthKeysTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('auth_keys', function (Blueprint $table) {
//            $table->primary('id');
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('auth_key')->unique();
            $table->timestamp('expired_at')->useCurrent();
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
    public function down() {
        Schema::dropIfExists('auth_keys');
    }

}
