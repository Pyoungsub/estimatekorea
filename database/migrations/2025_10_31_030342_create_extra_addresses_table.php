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
        Schema::create('extra_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('road_id')->constrained()->onDelete('cascade');
            $table->char('postcode',5)->index(); // postcode
            $table->string('extra_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_addresses');
    }
};
