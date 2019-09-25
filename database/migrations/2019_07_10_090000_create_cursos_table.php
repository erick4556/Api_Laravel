<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',200);
            $table->text('descripcion');
            $table->string('icono',200);
            $table->string('portada',200);
            $table->string('video',200);
            $table->string('etiquetas',200);
            $table->unsignedInteger('profesor_id');
            $table->unsignedInteger('categoria_id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('profesor_id')->references('id')->on('profesors');
            $table->foreign('categoria_id')->references('id')->on('categorias');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursos');
    }
}
