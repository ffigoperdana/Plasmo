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
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'stok_plasma_a_positif',
                'stok_plasma_a_negatif',
                'stok_plasma_b_positif',
                'stok_plasma_b_negatif',
                'stok_plasma_ab_positif',
                'stok_plasma_ab_negatif',
                'stok_plasma_o_positif',
                'stok_plasma_o_negatif',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('stok_plasma_a_positif')->nullable();
            $table->integer('stok_plasma_a_negatif')->nullable();
            $table->integer('stok_plasma_b_positif')->nullable();
            $table->integer('stok_plasma_b_negatif')->nullable();
            $table->integer('stok_plasma_ab_positif')->nullable();
            $table->integer('stok_plasma_ab_negatif')->nullable();
            $table->integer('stok_plasma_o_positif')->nullable();
            $table->integer('stok_plasma_o_negatif')->nullable();
        });
    }
};
