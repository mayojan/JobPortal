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
        Schema::table('jobs', function (Blueprint $table) {
            $table->index('job_title'); // ایندکس روی عنوان شغل برای بالا بردن سرعت سرچ
            $table->index('employer_id'); // ایندکس روی کلید خارجی کارفرما برای ارتباط سریع‌تر
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropIndex(['job_title']);
            $table->dropIndex(['employer_id']);
        });
    }
};
