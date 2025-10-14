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
        Schema::table('publikasis', function (Blueprint $table) {
            // Tambahkan kolom foreign key setelah kolom 'id'
            $table->foreignId('id_kategori')
                  ->after('id') // Opsional, agar posisi kolom rapi
                  ->constrained('kategori') // Menghubungkan ke tabel 'kategoris'
                  ->onDelete('cascade'); // Jika kategori dihapus, publikasi terkait juga terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publikasis', function (Blueprint $table) {
            // Hapus relasi dan kolom jika migration di-rollback
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};

