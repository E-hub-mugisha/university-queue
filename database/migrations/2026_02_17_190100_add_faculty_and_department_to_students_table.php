<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('faculty')->nullable()->after('user_id');
            $table->string('department')->nullable()->after('faculty');
        });

        // Backfill department for existing records from legacy `program`.
        DB::table('students')
            ->whereNull('department')
            ->update(['department' => DB::raw('program')]);
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['faculty', 'department']);
        });
    }
};
