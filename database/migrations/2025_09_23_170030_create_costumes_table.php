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
        Schema::create('costumes', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');  
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['returned', 'lost', 'pending'])->default('pending');
            $table->date('date_returned')->nullable();
            $table->date('date_lost')->nullable();
            $table->date('date_complied')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costumes');
    }
};
