<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('size'); // diameter in km
            $table->string('distance_from_sun'); // in AU or km
            $table->string('mass')->nullable();
            $table->string('orbital_period')->nullable(); // in days/years
            $table->string('rotation_period')->nullable(); // in hours/days
            $table->string('temperature')->nullable(); // in Celsius
            $table->integer('moons')->default(0);
            $table->string('type'); // terrestrial, gas giant, etc
            $table->string('image')->nullable();
            $table->boolean('is_habitable')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planets');
    }
};