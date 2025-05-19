<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItinerariosLugaresTable extends Migration
{
    public function up()
    {
        Schema::create('itinerarios_lugares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerario_id')->constrained('itinerarios')->onDelete('cascade');
            $table->foreignId('lugar_id')->constrained('lugares')->onDelete('cascade');
            $table->integer('dia');
        });
    }

    public function down()
    {
        Schema::dropIfExists('itinerario_lugar');
    }
}
