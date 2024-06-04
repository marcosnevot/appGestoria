<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('web_messages', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email');
            $table->string('sede');
            $table->string('asunto');
            $table->text('mensaje');
            $table->timestamp('fecha_creacion')->useCurrent()->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('web_messages');
    }
}
