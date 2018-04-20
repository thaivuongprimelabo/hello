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
        
        DB::table('users')->insert(
                array(
                    'id' => 2,
                    'name' => 'Zenrin Administrator',
                    'loginid' => 'zenrin',
                    'password' => Hash::make('zenrin@123'),
                    'locked' => 0
                )
        );
        
        DB::table('users')->insert(array('id' => 3,'name' => 'Administrator','loginid' => 'songviytuong3','password' => Hash::make('cadillac'),'locked' => 0));
        DB::table('users')->insert(array('id' => 4,'name' => 'Administrator','loginid' => 'songviytuong4','password' => Hash::make('cadillac'),'locked' => 0));
        DB::table('users')->insert(array('id' => 5,'name' => 'Administrator','loginid' => 'songviytuong5','password' => Hash::make('cadillac'),'locked' => 1));
        DB::table('users')->insert(array('id' => 6,'name' => 'Administrator','loginid' => 'songviytuong6','password' => Hash::make('cadillac'),'locked' => 1));
        DB::table('users')->insert(array('id' => 7,'name' => 'Administrator','loginid' => 'songviytuong7','password' => Hash::make('cadillac'),'locked' => 0));
        DB::table('users')->insert(array('id' => 8,'name' => 'Administrator','loginid' => 'songviytuong8','password' => Hash::make('cadillac'),'locked' => 0));
        DB::table('users')->insert(array('id' => 9,'name' => 'Administrator','loginid' => 'songviytuong9','password' => Hash::make('cadillac'),'locked' => 0));
        DB::table('users')->insert(array('id' => 10,'name' => 'Administrator','loginid' => 'songviytuong10','password' => Hash::make('cadillac'),'locked' => 0));
        DB::table('users')->insert(array('id' => 11,'name' => 'Administrator','loginid' => 'songviytuong11','password' => Hash::make('cadillac'),'locked' => 0));
        DB::table('users')->insert(array('id' => 12,'name' => 'Administrator','loginid' => 'songviytuong12','password' => Hash::make('cadillac'),'locked' => 0));
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
