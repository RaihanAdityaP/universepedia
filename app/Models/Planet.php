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
        'mass',
        'orbital_period',
        'rotation_period',
        'temperature',
        'moons',
        'type',
        'image',
        'is_habitable',
    ];

    protected $casts = [
        'is_habitable' => 'boolean',
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
            'dwarf' => 'secondary',
            default => 'dark'
        };
    }
}