<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('info_hub', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('poster_image')->nullable();
            $table->string('poster_link')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_hub');
    }
};
