
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('invitation_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->string('invitation_code');
            $table->boolean('code_used')->default(0);
            $table->timestamps();
        });

    }

    public function down(): void
    {

        Schema::dropIfExists('invitation_codes');

    }
};
