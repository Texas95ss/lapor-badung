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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            // Komen ini nempel di Laporan mana?
            $table->foreignId('report_id')->constrained()->cascadeOnDelete();
            // Siapa yang komen? (Bisa warga, bisa admin)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Isi komentarnya
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
