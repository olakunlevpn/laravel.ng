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
        Schema::table('envato_purchases', function (Blueprint $table) {
            $table->string('purchase_code')->nullable(false);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('envato_purchases', function (Blueprint $table) {
            $table->dropColumn('purchase_code');
        });
    }
};
