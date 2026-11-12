<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('king_monitor_user_exceededs', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('Tipo [1 = request, 2 = error]');
            $table->bigInteger('king_user_id')->nullable()->constrained()->comment('Usuario que excedio el limite de peticiones');
            $table->text('token')->nullable()->comment('token con el cual se realiza la accion');
            $table->string('ip', 255)->comment('ip de la accion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('king_monitor_user_exceededs');
    }
};
