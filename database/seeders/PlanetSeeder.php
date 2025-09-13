<?php

namespace Database\Seeders;

use App\Models\Planet;
use Illuminate\Database\Seeder;

class PlanetSeeder extends Seeder
{
    public function run(): void
    {
        $planets = [
            [
                'name' => 'Mercury',
                'description' => 'Mercury is the smallest planet in our solar system and closest to the Sun. It has extreme temperature variations, with scorching hot days and freezing cold nights. Its surface is heavily cratered, similar to our Moon, and it has no atmosphere to speak of.',
                'size' => '4,879 km',
                'distance_from_sun' => '0.39 AU (58 million km)',
                'mass' => '3.30 × 10²³ kg',
                'orbital_period' => '88 Earth days',
                'rotation_period' => '59 Earth days',
                'temperature' => '-173°C to 427°C',
                'moons' => 0,
                'type' => 'terrestrial',
                'is_habitable' => false,
                'image' => 'planets/mercury.jpg', // Will be placeholder for now
            ],
            [
                'name' => 'Venus',
                'description' => 'Venus is the second planet from the Sun and the hottest planet in our solar system due to its thick atmosphere of carbon dioxide that traps heat. It rotates backwards compared to most planets and has surface pressures 90 times greater than Earth.',
                'size' => '12,104 km',
                'distance_from_sun' => '0.72 AU (108 million km)',
                'mass' => '4.87 × 10²⁴ kg',
                'orbital_period' => '225 Earth days',
                'rotation_period' => '243 Earth days',
                'temperature' => '462°C (surface)',
                'moons' => 0,
                'type' => 'terrestrial',
                'is_habitable' => false,
                'image' => 'planets/venus.jpg',
            ],
            [
                'name' => 'Earth',
                'description' => 'Earth is the third planet from the Sun and the only known planet with life. It has a perfect distance from the Sun, liquid water, and a protective atmosphere. Our blue planet is home to millions of species and has diverse climates and ecosystems.',
                'size' => '12,756 km',
                'distance_from_sun' => '1 AU (150 million km)',
                'mass' => '5.97 × 10²⁴ kg',
                'orbital_period' => '365.25 days',
                'rotation_period' => '24 hours',
                'temperature' => '-89°C to 58°C',
                'moons' => 1,
                'type' => 'terrestrial',
                'is_habitable' => true,
                'image' => 'planets/earth.jpg',
            ],
            [
                'name' => 'Mars',
                'description' => 'Mars, known as the Red Planet, is the fourth planet from the Sun. It has polar ice caps, the largest volcano in the solar system (Olympus Mons), and evidence of ancient water flow. Scientists are actively searching for signs of past or present life on Mars.',
                'size' => '6,792 km',
                'distance_from_sun' => '1.52 AU (228 million km)',
                'mass' => '6.42 × 10²³ kg',
                'orbital_period' => '687 Earth days',
                'rotation_period' => '24.6 hours',
                'temperature' => '-87°C to -5°C',
                'moons' => 2,
                'type' => 'terrestrial',
                'is_habitable' => false,
                'image' => 'planets/mars.jpg',
            ],
            [
                'name' => 'Jupiter',
                'description' => 'Jupiter is the largest planet in our solar system, a gas giant with a Great Red Spot storm that has been raging for centuries. It acts as a cosmic vacuum cleaner, protecting inner planets from asteroids and comets with its powerful gravitational field.',
                'size' => '142,984 km',
                'distance_from_sun' => '5.2 AU (778 million km)',
                'mass' => '1.90 × 10²⁷ kg',
                'orbital_period' => '12 Earth years',
                'rotation_period' => '9.9 hours',
                'temperature' => '-108°C (cloud tops)',
                'moons' => 95,
                'type' => 'gas_giant',
                'is_habitable' => false,
                'image' => 'planets/jupiter.jpg',
            ],
            [
                'name' => 'Saturn',
                'description' => 'Saturn is famous for its spectacular ring system made of ice and rock particles. It is a gas giant and the least dense planet in our solar system - so light it would float in water if there was an ocean large enough!',
                'size' => '120,536 km',
                'distance_from_sun' => '9.5 AU (1.4 billion km)',
                'mass' => '5.68 × 10²⁶ kg',
                'orbital_period' => '29.5 Earth years',
                'rotation_period' => '10.7 hours',
                'temperature' => '-139°C (cloud tops)',
                'moons' => 146,
                'type' => 'gas_giant',
                'is_habitable' => false,
                'image' => 'planets/saturn.jpg',
            ],
            [
                'name' => 'Uranus',
                'description' => 'Uranus is an ice giant that rotates on its side, making it unique among planets. It has a faint ring system and is composed mainly of water, methane, and ammonia ices. Its blue-green color comes from methane in its atmosphere.',
                'size' => '51,118 km',
                'distance_from_sun' => '19.2 AU (2.9 billion km)',
                'mass' => '8.68 × 10²⁵ kg',
                'orbital_period' => '84 Earth years',
                'rotation_period' => '17.2 hours',
                'temperature' => '-197°C',
                'moons' => 27,
                'type' => 'ice_giant',
                'is_habitable' => false,
                'image' => 'planets/uranus.jpg',
            ],
            [
                'name' => 'Neptune',
                'description' => 'Neptune is the farthest planet from the Sun and has the fastest winds in the solar system, reaching speeds of up to 2,100 km/h. It appears blue due to methane in its atmosphere and was the first planet discovered through mathematical predictions.',
                'size' => '49,528 km',
                'distance_from_sun' => '30.1 AU (4.5 billion km)',
                'mass' => '1.02 × 10²⁶ kg',
                'orbital_period' => '165 Earth years',
                'rotation_period' => '16.1 hours',
                'temperature' => '-201°C',
                'moons' => 16,
                'type' => 'ice_giant',
                'is_habitable' => false,
                'image' => 'planets/neptune.jpg',
            ],
        ];

        foreach ($planets as $planet) {
            Planet::create($planet);
        }
        
        $this->command->info('Planets seeded successfully!');
    }
}