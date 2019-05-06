<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });


        // Schema::create('userinfos', function (Blueprint $table) {
        //     $table->increments('user_id');
        //     $table->string('nickname');
        //     $table->string('imageUrl');
        //     $table->string('editor');
        //     $table->string('language');
        //     $table->string('letter');
        //     $table->string('notification');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
