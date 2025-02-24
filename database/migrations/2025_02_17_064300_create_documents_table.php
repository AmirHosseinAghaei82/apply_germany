<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\text;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('high_school')->nullable();
            $table->text('high_school_description')->nullable();
            $table->text('bachelor')->nullable();
            $table->text('bachelor_description')->nullable();
            $table->text('language')->nullable();
            $table->text('language_description')->nullable();
            $table->text('passport')->nullable();
            $table->text('passport_description')->nullable();
            $table->text('image')->nullable();
            $table->text('image_description')->nullable();
            $table->text('exam_success')->nullable();
            $table->text('exam_success_description')->nullable();
            $table->text('work')->nullable();
            $table->text('work_description')->nullable();
            $table->text('other')->nullable();
            $table->text('other_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
