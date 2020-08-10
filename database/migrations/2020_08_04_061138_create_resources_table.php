<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('resources', function (Blueprint $table) {
            $table->increments('resourceID');
            $table->string('title');
            $table->string('type');
            $table->string('note');
            $table->string('url');
            $table->string('sermonID');
            $table->string('isPublic');
            $table->string('uploadby');
            $table->string('artist');
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
        Schema::dropIfExists('resources');
        
    }
}
