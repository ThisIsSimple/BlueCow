<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trashes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trashcan_id')->unsigned();
            $table->double('out')->nullable();
            $table->double('in');
            $table->double('humidity');
            $table->double('ultrawave');
            $table->double('weight');
            $table->timestamps();
            $table->foreign('trashcan_id')
                ->references('id')->on('trashcans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trashes');
    }
}
