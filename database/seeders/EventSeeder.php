<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Perseids Meteor Shower',
                'description' => 'One of the most spectacular meteor showers of the year, producing up to 100 meteors per hour at its peak.',
                'type' => 'meteor_shower',
                'date' => '2025-08-12',
                'created_by' => 1,
            ],
            [
                'title' => 'Total Solar Eclipse',
                'description' => 'A rare celestial event where the Moon completely covers the Sun, casting a shadow on Earth.',
                'type' => 'eclipse',
                'date' => '2025-09-15',
                'created_by' => 1,
            ],
            [
                'title' => 'Great Planetary Alignment',
                'description' => 'A rare alignment of Jupiter, Saturn, Mars, Venus, and Mercury visible in the night sky.',
                'type' => 'planet_alignment',
                'date' => '2025-06-20',
                'created_by' => 1,
            ],
            [
                'title' => 'Halley\'s Comet Appearance',
                'description' => 'The famous periodic comet makes its closest approach to Earth this decade.',
                'type' => 'comet_appearance',
                'date' => '2025-11-05',
                'created_by' => 1,
            ],
            [
                'title' => 'Super Blue Moon',
                'description' => 'A rare combination of a supermoon and blue moon, appearing larger and brighter than usual.',
                'type' => 'supermoon',
                'date' => '2025-10-31',
                'created_by' => 1,
            ],
            [
                'title' => 'Geminids Meteor Shower',
                'description' => 'One of the best annual meteor showers, known for its bright, colorful meteors.',
                'type' => 'meteor_shower',
                'date' => '2025-12-14',
                'created_by' => 1,
            ],
            [
                'title' => 'Quadrantids Meteor Shower',
                'description' => 'Starting the year with a bang, this meteor shower can produce up to 40 meteors per hour.',
                'type' => 'meteor_shower',
                'date' => '2025-01-03',
                'created_by' => 1,
            ],
            [
                'title' => 'Lunar Eclipse',
                'description' => 'A beautiful lunar eclipse where Earth\'s shadow falls on the Moon, turning it a reddish color.',
                'type' => 'eclipse',
                'date' => '2025-03-14',
                'created_by' => 1,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}