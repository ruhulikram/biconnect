<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['discussion', 'project']);
            $table->string('title')->nullable();
            $table->text('body');
            $table->string('image')->nullable();
            $table->date('deadline')->nullable();
            $table->string('campus_area')->nullable();
            $table->enum('project_type', ['paid', 'unpaid', 'portfolio'])->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['type', 'is_active']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
