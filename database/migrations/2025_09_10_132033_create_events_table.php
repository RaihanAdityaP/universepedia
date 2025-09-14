<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('date');
            $table->string('location');
            $table->enum('type', [
                'meteor_shower',
                'eclipse',
                'planet_alignment',
                'asteroid_flyby',
                'supernova',
                'other'
            ])->default('other');
            $table->string('visibility')->nullable(); // visible from which regions
            $table->time('time')->nullable();
            $table->string('duration')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};