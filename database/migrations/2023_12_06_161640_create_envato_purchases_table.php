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
        Schema::create('envato_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->decimal('amount', 8, 2);
            $table->dateTime('sold_at');
            $table->string('license');
            $table->decimal('support_amount', 8, 2);
            $table->dateTime('supported_until')->nullable();
            $table->bigInteger('item_id');
            $table->string('item_name');
            $table->dateTime('item_updated_at');
            $table->string('item_site');
            $table->integer('price_cents');
            $table->string('buyer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envato_purchases');
    }
};
