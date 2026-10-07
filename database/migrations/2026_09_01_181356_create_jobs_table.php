<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Decimal;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
        $table->id('job_id');
        $table->foreignId('employer_id')->constrained('employers', 'employer_id')->onDelete('cascade');
        $table->string('job_title');
        $table->text('description');
        $table->decimal('salary', 10, 2)->nullable();
        $table->string('location');
        $table->enum('type', ['full-time', 'part-time', 'remote', 'contract'])->default('full-time');
        $table->date('deadline');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
