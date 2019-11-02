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
            $table->decimal('lat',16,14);
            $table->decimal('long',16,14);
            $table->integer('freq');
            $table->integer('src')->unique()->unsigned();
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
