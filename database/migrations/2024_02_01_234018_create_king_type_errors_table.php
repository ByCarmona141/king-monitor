<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('king_type_errors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->unique()->comment('Nombre del tipo de error');
            $table->string('description', 255)->nullable()->comment('Descripcion del error');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('king_type_errors');
    }
};
