<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Geminids Meteor Shower',
                'description' => 'The Geminids are widely considered to be the best meteor shower of the year, producing up to 120 multicolored meteors per hour at its peak. The meteors appear to radiate from the constellation Gemini.',
                'date' => Carbon::now()->addDays(30),
                'location' => 'Worldwide',
                'type' => 'meteor_shower',
                'visibility' => 'Best viewed from Northern Hemisphere',
                'time' => '22:00',
                'duration' => 'All night',
                'is_recurring' => true,
            ],
            [
                'title' => 'Total Solar Eclipse',
                'description' => 'A total solar eclipse occurs when the Moon passes between Earth and the Sun, completely blocking the face of the Sun for a brief period. This creates a spectacular celestial event.',
                'date' => Carbon::now()->addDays(120),
                'location' => 'North America',
                'type' => 'eclipse',
                'visibility' => 'Path of totality across North America',
                'time' => '14:30',
                'duration' => '4 minutes',
                'is_recurring' => false,
            ],
            [
                'title' => 'Mars Opposition',
                'description' => 'Mars opposition occurs when Earth passes between the Sun and Mars, making Mars appear brightest and largest in the night sky. This is the best time to observe Mars.',
                'date' => Carbon::now()->addDays(90),
                'location' => 'Worldwide',
                'type' => 'planet_alignment',
                'visibility' => 'Visible worldwide after sunset',
                'time' => '21:00',
                'duration' => 'All night',
                'is_recurring' => false,
            ],
            [
                'title' => 'SpaceX Starship Mission to Mars',
                'description' => 'SpaceX plans to launch its Starship spacecraft on an uncrewed mission to Mars, marking a significant step toward human colonization of the Red Planet.',
                'date' => Carbon::now()->addDays(200),
                'location' => 'Boca Chica, Texas',
                'type' => 'rocket_launch',
                'visibility' => 'Live stream available worldwide',
                'time' => '15:00',
                'duration' => '2 hours',
                'is_recurring' => false,
            ],
            [
                'title' => 'Asteroid 2023 BU Close Approach',
                'description' => 'Asteroid 2023 BU will make a close but safe approach to Earth, passing within 0.1 lunar distances. This provides a great opportunity for astronomical observation.',
                'date' => Carbon::now()->addDays(15),
                'location' => 'Space',
                'type' => 'asteroid_flyby',
                'visibility' => 'Visible with telescopes',
                'time' => '03:27',
                'duration' => '30 minutes',
                'is_recurring' => false,
            ],
            [
                'title' => 'International Space Station Flyover',
                'description' => 'The International Space Station will be making a bright pass over major cities, appearing as a fast-moving bright star across the sky.',
                'date' => Carbon::now()->addDays(5),
                'location' => 'Major Cities Worldwide',
                'type' => 'other',
                'visibility' => 'Visible to naked eye',
                'time' => '19:45',
                'duration' => '6 minutes',
                'is_recurring' => true,
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}