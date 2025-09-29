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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flat_id')->constrained()->onDelete('cascade');
            $table->foreignId('house_owner_id')->constrained()->onDelete('cascade');
            $table->foreignId('bill_category_id')->constrained('bill_categories')->onDelete('cascade');
            $table->date('month');
            $table->decimal('amount', 12, 2);
            $table->decimal('due_amount', 12, 2)->default(0);
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
