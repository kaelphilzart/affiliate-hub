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
        Schema::create('track_audiences', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('ip_address');
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // 🔥 optional: biar cepat query & anti duplicate kasar
            $table->index(['product_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_audiences');
    }
};
