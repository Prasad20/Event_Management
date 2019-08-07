<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Invites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Invites', function (Blueprint $table) {
            $table->bigInteger('userid')->unsigned();
            $table->bigInteger('eventid')->unsigned();
            $table->foreign('userid')->references('id')->on('Users')->onDelete("cascade");
            $table->foreign('eventid')->references('id')->on('Events')->onDelete("cascade");
            $table->primary(['userid','eventid']);
            $table->enum('status',['accept','reject','hold'])->default('hold');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Invites');
    }
}
