<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('musics', function (Blueprint $table) {
            $table->bigInteger('file_size')->nullable()->after('file_path');
            $table->boolean('is_public')->default(true)->after('is_approved');
            $table->enum('status', ['pending', 'approved', 'rejected', 'deleted'])->default('pending')->after('is_public');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('musics', function (Blueprint $table) {
            $table->dropColumn(['file_size', 'is_public', 'status']);
        });
    }
};
