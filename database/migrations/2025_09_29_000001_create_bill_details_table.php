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
        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained()->onDelete('cascade');
            $table->foreignId('bill_category_id')->constrained('bill_categories')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Ensure one category per bill
            $table->unique(['bill_id', 'bill_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_details');
    }
};