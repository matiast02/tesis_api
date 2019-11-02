<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatewaysTable extends Migration
{

    public function up()
    {
        Schema::create('Gateways', function(Blueprint $table) {
            $table->increments('id');
            $table->string('gw_id',50)->unique();
            $table->decimal('lat',16,14)->default(0.00000);
            $table->decimal('long',16,14)->default(0.00000);
            $table->integer('freq')->unsigned();
            $table->string('nombre',300);
            // Constraints declaration
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('Gateways');
    }
}
