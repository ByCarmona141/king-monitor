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

        Schema::create('king_monitors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('king_user_id')->nullable()->constrained()->comment('Usuario que realizo la accion');
            $table->string('tuple', 128)->nullable()->comment('Tupla (id) de la accion dependiendo si es un Create o Update, o Read de un dato en especifico se guarda el id del registro');
            $table->string('method', 255)->comment('Metodo HTTP para la accion');
            $table->text('endpoint')->comment('Endpoint de la accion realizada');
            $table->text('headers')->nullable()->comment('headers de la accion');
            $table->text('token')->nullable()->comment('token con el cual se realiza la accion');
            $table->string('ip', 255)->comment('ip de la accion');
            $table->longText('params')->nullable()->comment('Datos enviados para la accion');
            $table->string('code', 255)->comment('Codigo de la respuesta');
            $table->longText('response')->comment('Respuesta de la accion');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('king_monitors');
    }
};
