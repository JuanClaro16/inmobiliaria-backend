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
        Schema::table('properties', function (Illuminate\Database\Schema\Blueprint $t) {
            $t->boolean('has_pool')->default(false);
            $t->boolean('has_elevator')->default(false);
            $t->enum('parking_type', ['none', 'dos', 'comunal'])->default('none');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Illuminate\Database\Schema\Blueprint $t) {
            $t->dropColumn(['has_pool', 'has_elevator', 'parking_type']);
        });
    }

};
