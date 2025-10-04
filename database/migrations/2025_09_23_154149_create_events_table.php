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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('mode')->nullable();
            $table->enum('status', ['available', 'unavailable', 'cancelled'])->default('available');
            $table->boolean('is_show_event')->default(false); // left column if true
            $table->string('client')->nullable();
            $table->string('venue')->nullable();
            $table->string('type')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->integer('required_performers')->nullable();
            $table->text('description')->nullable();
            $table->json('selected_performers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
