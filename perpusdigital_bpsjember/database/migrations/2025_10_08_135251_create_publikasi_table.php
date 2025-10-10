<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publikasi', function (Blueprint $table) {
            $table->id();

            $table->string('judul', 255);
            $table->text('deskripsi')->nullable();

            // FK ke tabel categories
            $table->unsignedBigInteger('id_kategori')->nullable();

            $table->enum('tipe_file', ['pdf', 'ppt', 'docx', 'jpg', 'png', 'mp4', 'link']);
            $table->string('file_path', 255)->nullable();

            // FK ke users (pengunggah)
            $table->unsignedBigInteger('uploaded_by')->nullable();

            $table->enum('status', ['tertunda', 'diterima', 'ditolak'])->default('tertunda');

            $table->timestamps();

            // Relasi ke tabel categories
            $table->foreign('id_kategori')
                  ->references('id')
                  ->on('kategori')
                  ->onDelete('set null');

            // Relasi ke tabel users
            $table->foreign('uploaded_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};