<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('fuel_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
        $table->foreignId('driver_id')->nullable()->constrained('users')->nullOnDelete();
        $table->float('liters');              // Количество топлива
        $table->float('price_per_liter');     // Цена за литр
        $table->float('total_cost');          // Итоговая стоимость
        $table->integer('odometer');          // Пробег на момент заправки
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('fuel_logs');
}

};
