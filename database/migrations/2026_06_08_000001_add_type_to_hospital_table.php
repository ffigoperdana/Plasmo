<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hospital', function (Blueprint $table) {
            $table->string('type')->default('rumah-sakit')->after('hotline');
        });
    }

    public function down(): void
    {
        Schema::table('hospital', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
