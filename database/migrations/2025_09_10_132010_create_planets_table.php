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
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('size');
            $table->string('distance_from_sun')->nullable();
            $table->string('diameter')->nullable();
            $table->string('mass')->nullable();
            $table->string('orbital_period')->nullable();
            $table->string('rotation_period')->nullable();
            $table->string('temperature')->nullable();
            $table->integer('moons')->nullable()->default(0);
            $table->string('type');
            $table->string('atmosphere')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_habitable')->default(false);
            $table->boolean('has_rings')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planets');
    }
};