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
        Schema::create('supplier_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inquiry_id');
            $table->foreignId('supplier_id');
            $table->longText('msgTitle');
            $table->longText('msg');
            $table->string('lang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_inquiries');
    }
};
