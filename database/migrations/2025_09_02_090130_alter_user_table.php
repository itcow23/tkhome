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
        Schema::table('user', function (Blueprint $table) {
            // Bước 1: xóa foreign key nếu có
            $table->dropForeign(['role_id']);
        });
        Schema::table('user', function (Blueprint $table) {
            // Bước 2: thay đổi cột
            $table->unsignedBigInteger('role_id')->default(1)->change();
        });

        Schema::table('user', function (Blueprint $table) {
            // Bước 3: thêm lại foreign key nếu cần
            $table->foreign('role_id')->references('id')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('user', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->integer('role_id')->change();
            $table->foreign('role_id')->references('id')->on('role');
        });
    }
};
