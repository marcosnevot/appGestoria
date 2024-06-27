<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tarea', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha_creacion')->useCurrent()->nullable();
            $table->timestamp('fecha_fin')->nullable();
            $table->boolean('facturado')->default(false)->nullable();
            $table->decimal('suplidos', 10, 2)->nullable();
            $table->decimal('coste', 10, 2)->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->enum('estado', ['pendiente', 'en_progreso', 'completada'])->default('pendiente')->nullable();
            $table->string('tipo')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('creado_por')->nullable();
            $table->foreign('id_cliente')->references('id')->on('cliente')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tarea');
    }
};
