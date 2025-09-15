<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->unsignedTinyInteger('rooms')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->enum('consignation_type', ['rent', 'sale', 'rent_sale'])->default('rent');
            $table->unsignedBigInteger('rent_price')->nullable();
            $table->unsignedBigInteger('sale_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
