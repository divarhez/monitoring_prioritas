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
        Schema::create('maintenance_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maintenance_schedule_id');
            $table->unsignedBigInteger('device_id');
            $table->text('result');
            $table->text('recommendation')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->foreign('maintenance_schedule_id')->references('id')->on('maintenance_schedules')->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_reports');
    }
};
