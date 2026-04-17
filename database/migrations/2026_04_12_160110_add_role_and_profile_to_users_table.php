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
            //Role: Buyer (pembeli) atau Seller (penjual)
            $table->enum('role',['buyer','seller'])->default('buyer')->after('email');

            //Data profil tambahan
            $table->string('phone')->nullable()->after('role');
            $table->string('address')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('address');

            //Soft delete: user tidak benar benar di hapus dari DB
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(['role', 'phone', 'address', 'avatar']);
            $table->dropSoftDeletes();
        });
    }
};
