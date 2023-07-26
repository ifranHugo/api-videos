<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('serie_video', function (Blueprint $table) {
            $table->foreignId('video_id')->constrained();
            $table->foreignId('serie_id')->constrained();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('serie_video');
    }
};
