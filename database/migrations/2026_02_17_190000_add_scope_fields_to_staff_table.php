<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('campus')->nullable()->after('office_id');
            $table->string('faculty')->nullable()->after('campus');
            $table->string('department')->nullable()->after('faculty');
        });
    }

    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropColumn(['campus', 'faculty', 'department']);
        });
    }
};
