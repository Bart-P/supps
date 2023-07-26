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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->string('type');
            $table->string('name1');
            $table->string('name2')->nullable();
            $table->string('name3')->nullable();
            $table->string('street');
            $table->string('street_nr');
            $table->string('city_code');
            $table->string('city');
            $table->string('country');
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
