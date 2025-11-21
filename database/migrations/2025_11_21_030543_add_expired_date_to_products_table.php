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
        Schema::table('products', function (Blueprint $table) {
            $table->date('expired_date')->nullable()->after('stock');
            $table->date('manufacture_date')->nullable()->after('expired_date');
            $table->string('batch_number')->nullable()->after('manufacture_date');
            $table->boolean('has_expiry')->default(false)->after('batch_number');
            $table->integer('days_to_expire')->nullable()->after('has_expiry');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'expired_date', 
                'manufacture_date', 
                'batch_number',
                'has_expiry',
                'days_to_expire'
            ]);
        });
    }
};