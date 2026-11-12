<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('king_monitor_averages', function (Blueprint $table) {
            $table->id();
            $table->integer('king_type_average_id')->comment('Tipo de promedio [Errores o Correctos]');
            $table->integer('king_time_id')->comment('Tipo de tiempo que fue usado, dia, semana, mes, trimestre, annio');
            $table->string('initial_period')->comment('Periodo inicial');
            $table->string('final_period')->comment('Periodo final');
            $table->bigInteger('average')->comment('Promedio del monitor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('king_monitor_averages');
    }
};
