<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('luasarea');
            $table->string('notelp');
            $table->date('tanggal_order');

            $table->text('catatan')->nullable();

            // ✅ grade_id dibuat nullable karena FK pakai SET NULL
            $table->foreignId('grade_id')
                  ->nullable()
                  ->constrained('grades')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();

            // tank_type (pengganti kategori)
            $table->enum('tank_type', ['tanam', 'fiber'])->nullable();

            // status default "Belum Mulai"
            $table->string('status')->default('Belum Mulai');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
