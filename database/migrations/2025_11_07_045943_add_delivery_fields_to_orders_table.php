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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete()->after('user_id');
            $table->decimal('address_lat', 10, 7)->nullable()->after('address');
            $table->decimal('address_lng', 10, 7)->nullable()->after('address_lat');
            $table->text('notes')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn(['assigned_to', 'address_lat', 'address_lng', 'notes']);
        });
    }
};
