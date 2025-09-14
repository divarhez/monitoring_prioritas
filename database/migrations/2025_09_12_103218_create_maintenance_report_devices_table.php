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
        Schema::create('maintenance_report_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maintenance_report_id');
            $table->unsignedBigInteger('device_id');
            $table->timestamps();
            $table->foreign('maintenance_report_id')->references('id')->on('maintenance_reports')->onDelete('cascade');
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_report_devices');
    }
};
