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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id');
            $table->foreignId('expense_category_id');
            $table->decimal('amount', 12, 2);
            $table->string('check_no')->nullable();
            $table->string('expense_name');
            $table->boolean('is_approved')->default(false);
            $table->date('date')->nullable(); 
            $table->string('voucher_no')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
