<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            $table->primary('id');
            $table->integer('id')->unsigned();
            $table->string('name');
            $table->string('loginid',50)->unique();
            $table->char('password');
            $table->integer('locked');
            $table->rememberToken();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        
        /**
         * Account Demo
         */
        DB::table('users')->insert(
                array(
                    'id' => 1,
                    'name' => 'Administrator',
                    'loginid' => 'songviytuong',
                    'password' => Hash::make('cadillac'),
                    'locked' => 0
                )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
