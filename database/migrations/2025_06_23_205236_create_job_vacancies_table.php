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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->decimal('salary');
            $table->enum('type', ['full-time', 'part-time', 'hybrid', 'remote'])->default('full-time');
            $table->timestamps();
            $table->softDeletes();
            // Relationship
            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->restrictOnDelete();
            $table->uuid('category_id');
            $table->foreign('category_id')->references('id')->on('job_categories')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
