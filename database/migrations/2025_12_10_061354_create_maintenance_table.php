<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->string('type'); // замена масла, ТО-1, ремонт и т.д.
            $table->integer('odometer'); // пробег при выполнении
            $table->float('cost')->default(0);
            $table->date('service_date'); // дата обслуживания
            $table->string('service_center')->nullable(); // СТО
            $table->text('notes')->nullable(); // комментарии
            $table->date('next_service_date')->nullable(); // следующее обслуживание
            $table->integer('next_service_odometer')->nullable(); // след. пробег
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
