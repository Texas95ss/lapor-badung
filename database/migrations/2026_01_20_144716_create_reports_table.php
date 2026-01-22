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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            // Siapa yang lapor? (User ID)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Data Laporan
            $table->string('title'); // Judul: "Jalan Rusak di Mengwi"
            $table->text('description'); // Detail keluhan
            // KOREKSI: Menambahkan 'Lainnya' di sini
            $table->enum('category', ['Fasilitas', 'Jalan', 'Banjir', 'Sampah', 'Keamanan', 'Lainnya']); 
            $table->string('location'); // Lokasi
            $table->string('image'); // Bukti Foto
            
            // Status (State Machine)
            // Default 'pending' -> Admin confirm -> On Process -> Completed -> (User bisa rating)
            $table->enum('status', ['pending', 'proses', 'selesai', 'ditolak'])->default('pending');
            
            // Kolom untuk Rating & Review (Diisi saat status = selesai)
            $table->integer('rating')->nullable(); // Bintang 1-5
            $table->text('review')->nullable(); // "Terima kasih pak bupati"
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
