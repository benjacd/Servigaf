<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); // Foreign Key
            $table->string('product');
            $table->string('category');
            $table->text('repair_detail'); // Detalle de la reparación
            $table->dateTime('repair_date'); // Combined Date and Time
            $table->boolean('repair_accepted')->default(false); // Estado de aceptación de la reparación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repairs');
    }
}
