<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products_store', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->foreignId('store_id')
                ->nullable()
                ->constrained('stores')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            /*Log */
            $table->timestamps();
            $table->string('updated_by', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            /*Excluido */
            $table->date('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products_store');
    }
};
