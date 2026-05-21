<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->foreignId('prodi_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('prodis')
                  ->nullOnDelete();

            $table->enum('status', ['aktif', 'cuti', 'lulus', 'dropout'])
                  ->default('aktif')
                  ->after('telepon');

            $table->unsignedSmallInteger('angkatan')
                  ->nullable()
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropForeign(['prodi_id']);
            $table->dropColumn(['prodi_id', 'status', 'angkatan']);
        });
    }
};
