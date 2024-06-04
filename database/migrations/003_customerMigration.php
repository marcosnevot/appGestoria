<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->nullable(false);
            $table->string('telefono', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('numeroCuentaBancaria', 25)->nullable();
            $table->string('nif', 20)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cliente');
    }
};
