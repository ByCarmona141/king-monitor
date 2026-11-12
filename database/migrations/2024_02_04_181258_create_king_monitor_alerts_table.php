<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::disableForeignKeyConstraints();

        Schema::create('king_monitor_alerts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('king_user_id')->nullable()->constrained()->comment('Usuario al que pertenece la alerta');
            $table->text('token')->nullable()->comment('token con el cual se realiza la accion');
            $table->string('ip', 255)->comment('ip de la accion');
            $table->string('description', 255)->nullable()->comment('Descripcion de la alerta del usuario');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('king_monitor_alerts');
    }
};
