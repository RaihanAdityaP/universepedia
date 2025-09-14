<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'size',
        'distance_from_sun',
        'diameter',
        'mass',
        'orbital_period',
        'rotation_period',
        'temperature',
        'moons',
        'type',
        'atmosphere',
        'image',
        'is_habitable',
        'has_rings',
    ];

    protected $casts = [
        'is_habitable' => 'boolean',
        'has_rings' => 'boolean',
        'moons' => 'integer',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-planet.png');
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'terrestrial' => 'success',
            'gas_giant' => 'primary',
            'ice_giant' => 'info',
            'dwarf_planet' => 'secondary',
            'exoplanet' => 'warning',
            'other' => 'dark',
            default => 'dark'
        };
    }
}