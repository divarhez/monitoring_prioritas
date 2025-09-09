<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add department to users if not exists
        if (!Schema::hasColumn('users', 'department')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('department')->nullable()->after('name');
            });
        }

        // Add report_pdf to maintenance_reports if not exists
        if (!Schema::hasColumn('maintenance_reports', 'report_pdf')) {
            Schema::table('maintenance_reports', function (Blueprint $table) {
                $table->string('report_pdf')->nullable()->after('photo');
            });
        }
    }

    public function down(): void
    {
        // Drop report_pdf column if exists
        if (Schema::hasColumn('maintenance_reports', 'report_pdf')) {
            Schema::table('maintenance_reports', function (Blueprint $table) {
                $table->dropColumn('report_pdf');
            });
        }

        // Drop department column if exists
        if (Schema::hasColumn('users', 'department')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('department');
            });
        }
    }
};
