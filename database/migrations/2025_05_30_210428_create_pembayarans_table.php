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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kredit_id')->constrained('kredits')->onDelete('cascade');
            $table->date('tanggal_pembayaran');
            $table->integer('jumlah_pembayaran');
            $table->enum('status', ['menunggu_verifikasi', 'terverifikasi', 'gagal'])->default('menunggu_verifikasi');
            $table->string('bukti_transfer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
