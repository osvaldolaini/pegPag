<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->json('customer')->nullable();
            $table->json('items')->nullable();
            $table->foreignId('store_id')
                ->nullable()
                ->constrained('stores')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('value', $precision = 10, $scale = 2)->nullable();
            $table->string('pix_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
