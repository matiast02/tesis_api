<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodosTable extends Migration
{

    public function up()
    {
        Schema::create('Nodos', function(Blueprint $table) {
            $table->increments('id');
            $table->string('gw_id');
            $table->decimal('lat',10,8);
            $table->decimal('long',10,8);
            $table->integer('freq');
            $table->integer('dst');
            $table->integer('ptype');
            $table->integer('src')->unsigned();
            $table->integer('seq');
            $table->integer('len');
            $table->integer('snr');
            $table->integer('rssi');
            $table->integer('bw');
            $table->integer('cr');
            $table->integer('sf');
            $table->string('tdata');
            $table->decimal('tc',5,2);
            $table->decimal('pa',5,2);
            $table->decimal('co',5,2);
            $table->decimal('hu',5,2);
            $table->string('nombre',300);
            $table->foreign('gw_id')
                ->references('gw_id')
                ->on('gateways');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('Nodos');
    }
}
