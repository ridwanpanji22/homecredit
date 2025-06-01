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
        Schema::create('kredits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->integer('jumlah'); // jumlah barang
            $table->integer('total_harga');
            $table->enum('jenis_kredit', ['harian', 'mingguan', 'bulanan']);
            $table->integer('tenor'); // misal: berapa bulan/cicilan
            $table->integer('cicilan_per_periode'); // jumlah cicilan per periode
            $table->date('tanggal_mulai');
            $table->enum('status', ['aktif', 'lunas', 'menunggak'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kredits');
    }
};
