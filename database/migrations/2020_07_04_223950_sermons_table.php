<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SermonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('sermons', function (Blueprint $table) {
            $table->increments('sermonID');
            $table->string('topic');
            $table->string('author');
            $table->string('userID');
            $table->integer('status')->nullable();
            $table->string('resourceID');
            $table->string('postedby');
            $table->rememberToken();
            $table->timestamps();


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

        Schema::dropIfExists('sermons');
    }
}
