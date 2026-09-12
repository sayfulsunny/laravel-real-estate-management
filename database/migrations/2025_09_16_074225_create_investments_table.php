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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('project_id');
            $table->decimal('amount', 15, 2); 
            $table->string('invoice_no')->nullable();   
            $table->string('purpose')->nullable();
            // $table->string('flat_no')->nullable();
            $table->string('check_no')->nullable();
            $table->date('date')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
