<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientsTable extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('email'); // Eliminar la columna email
            $table->unsignedBigInteger('user_id')->unique()->nullable(false); // Añadir la columna user_id y asegurarse de que no sea nula

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Añadir la clave foránea
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('email'); // Volver a añadir la columna email en caso de revertir la migración
        });
    }
}
