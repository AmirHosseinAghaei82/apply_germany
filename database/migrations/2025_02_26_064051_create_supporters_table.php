<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('supporters', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->string('day');
            $table->string('start_time');
            $table->string('end_time');
            $table->boolean('is_reserved')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supporters');
    }
};
