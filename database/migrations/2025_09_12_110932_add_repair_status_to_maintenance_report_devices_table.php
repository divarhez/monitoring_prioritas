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
        Schema::table('maintenance_report_devices', function (Blueprint $table) {
            $table->boolean('is_problematic')->default(false)->after('device_id');
            $table->enum('repair_status', ['in_progress', 'completed'])->nullable()->after('is_problematic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_report_devices', function (Blueprint $table) {
            $table->dropColumn(['repair_status', 'is_problematic']);
        });
    }
};
