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
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->foreignId('house_owner_id')->constrained()->onDelete('cascade');
            $table->string('flat_number');
            $table->string('owner_name')->nullable();
            $table->string('owner_contact')->nullable();
            $table->string('owner_email')->nullable();
            $table->enum('available', ['yes', 'no'])->default('yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};
