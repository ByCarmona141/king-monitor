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

        Schema::create('king_monitor_errors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('king_user_id')->nullable()->constrained()->comment('Usuario que realizo la accion');
            $table->string('method', 255)->comment('Metodo HTTP para la accion');
            $table->text('endpoint')->comment('Endpoint de la accion realizada');
            $table->text('headers')->nullable()->comment('headers de la accion');
            $table->text('token')->nullable()->comment('token con el cual se realiza la accion');
            $table->string('ip', 255)->comment('ip de la accion');
            $table->longText('params')->nullable()->comment('Datos enviados para la accion');
            $table->string('code', 255)->comment('Codigo de la respuesta');
            $table->string('error', 255)->comment('Codigo de Error');
            $table->longText('message')->comment('Mensaje del error');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('king_monitor_errors');
    }
};
