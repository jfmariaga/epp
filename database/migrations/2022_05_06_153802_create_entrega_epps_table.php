<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrega_epps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empleado_id')->unsigned();
            // $table->string('labor');
            $table->string('motivo');
            // $table->string('estadoEpp');
            $table->date('fechaEntrega');
            $table->string('responsable');
            $table->bigInteger('epp_id')->unsigned();
            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('empleados')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('epp_id')->references('id')->on('epps')
            ->onDelete('cascade')
            ->onUpdate('cascade');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrega_epps');
    }
};
