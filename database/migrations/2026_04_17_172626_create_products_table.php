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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // seller yang memiliki produk ini
            $table->foreignId('user_id')
                  ->constrained()->cascadeOnDelete();
            // kategori produk
            $table->foreignId('category_id')->nullable()
                  ->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            //harga maks 9.999.999.999,99
            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            //path foto di storage
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
