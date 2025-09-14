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
        Schema::table('maintenance_schedules', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropColumn('agent_id');
        });

        Schema::dropIfExists('agents');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        Schema::table('maintenance_schedules', function (Blueprint $table) {
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');
        });
    }
};
