<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->string('code')->nullable();
            $table->string('title', 100)->nullable();
            $table->string('acronym', 50)->nullable();
            $table->string('logo_path', 100)->nullable();
            $table->string('key_pix', 100)->nullable();
            $table->string('city_pix', 100)->nullable();
            $table->string('slug', 150)->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->string('cpf_cnpj')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('number')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('complement')->nullable();
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
        Schema::dropIfExists('stores');
    }
};
