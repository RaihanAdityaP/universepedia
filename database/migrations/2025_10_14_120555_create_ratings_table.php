<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('ratable'); // ratable_id & ratable_type
            $table->tinyInteger('rating')->unsigned(); // 1-5
            $table->timestamps();
            
            // One rating per user per item
            $table->unique(['user_id', 'ratable_id', 'ratable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};