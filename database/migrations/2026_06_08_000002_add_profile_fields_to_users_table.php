<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('golongan_darah')->nullable()->after('role_id');
            $table->string('no_telepon')->nullable()->after('golongan_darah');
            $table->text('alamat')->nullable()->after('no_telepon');
            $table->integer('usia')->nullable()->after('alamat');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['golongan_darah', 'no_telepon', 'alamat', 'usia']);
        });
    }
};
