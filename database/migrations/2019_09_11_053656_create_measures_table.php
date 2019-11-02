<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('src')->unsigned();
            $table->integer('dst');
            $table->integer('ptype');
            $table->integer('seq');
            $table->integer('len');
            $table->integer('snr');
            $table->integer('rssi');
            $table->integer('bw');
            $table->integer('cr');
            $table->integer('sf');
            $table->string('tdata');
            $table->decimal('tc',5,2)->nullable();
            $table->decimal('pa',5,2)->nullable();
            $table->decimal('co',5,2)->nullable();
            $table->decimal('hu',5,2)->nullable();
            $table->decimal('hi',5,2)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('src')
                ->references('src')
                ->on('nodos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('measures');
    }
}
