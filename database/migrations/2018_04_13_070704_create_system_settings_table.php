<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemSettingsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->primary('key');
            $table->string('key', 64);
            $table->string('value', 255);
            $table->string('description', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        $settings = [
            ['key' => 'default_call_time', 'value' => 5],
            ['key' => 'default_retry', 'value' => 3]
        ];
        DB::table('system_settings')->insert($settings);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('system_settings');
    }

}
