<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected', 'closed'])
                ->default('pending')
                ->after('is_active');
        });

        // Backfill: existing active posts → approved, inactive → rejected
        DB::table('posts')->where('is_active', true)->update(['status' => 'approved']);
        DB::table('posts')->where('is_active', false)->update(['status' => 'rejected']);
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
