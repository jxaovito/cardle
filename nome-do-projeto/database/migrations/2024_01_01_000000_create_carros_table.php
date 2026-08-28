<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carros', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->string('marca');
            $table->string('carroceria');
            $table->decimal('motor', 3, 1);
            $table->integer('ano_lancamento');
            $table->integer('peso');
            $table->string('foto');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carros');
    }
};
