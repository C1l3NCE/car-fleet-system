<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->year('year');
            $table->string('reg_number')->unique();
            $table->string('vin')->nullable();
            $table->enum('type', ['легковой', 'грузовой', 'автобус', 'спецтехника']);
            $table->string('status')->default('in_service');
            $table->unsignedBigInteger('current_driver_id')->nullable();
            $table->integer('mileage')->default(0);
            $table->string('fuel_type')->nullable();
            $table->timestamps();
            $table->string('photo')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
