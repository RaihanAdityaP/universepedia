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
                'description' => 'The Geminids are widely considered to be the best meteor shower of the year, producing up to 120 multicolored meteors per hour at its peak. The meteors appear to radiate from the constellation Gemini and are caused by debris from asteroid 3200 Phaethon.',
                'date' => Carbon::now()->addDays(30),
                'location' => 'Worldwide',
                'type' => 'meteor_shower',
                'visibility' => 'Best viewed from Northern Hemisphere after 21:00',
                'time' => '22:00',
                'duration' => 'All night (peak: 02:00-04:00)',
                'is_recurring' => true,
                'image' => 'events/geminids.jpg',
            ],
            [
                'title' => 'Total Solar Eclipse',
                'description' => 'A total solar eclipse occurs when the Moon passes between Earth and the Sun, completely blocking the face of the Sun for observers in the path of totality. This creates a spectacular celestial event where day temporarily turns to night.',
                'date' => Carbon::now()->addDays(120),
                'location' => 'North America',
                'type' => 'eclipse',
                'visibility' => 'Path of totality across Mexico, US, and Canada',
                'time' => '14:30',
                'duration' => '4 minutes totality',
                'is_recurring' => false,
                'image' => 'events/solar_eclipse.jpg',
            ],
            [
                'title' => 'Mars Opposition',
                'description' => 'Mars opposition occurs when Earth passes between the Sun and Mars, making Mars appear brightest and largest in the night sky. This is the best time to observe the Red Planet and its surface features through telescopes.',
                'date' => Carbon::now()->addDays(90),
                'location' => 'Worldwide',
                'type' => 'planet_alignment',
                'visibility' => 'Visible worldwide after sunset, highest at midnight',
                'time' => '21:00',
                'duration' => 'All night (best viewing: 22:00-02:00)',
                'is_recurring' => false,
                'image' => 'events/mars_opposition.jpg',
            ],
            [
                'title' => 'SpaceX Starship Mission to Moon',
                'description' => 'SpaceX plans to launch its Starship spacecraft on an uncrewed mission around the Moon, marking a significant step toward lunar exploration and eventual human missions to Mars. This will be a historic milestone in commercial spaceflight.',
                'date' => Carbon::now()->addDays(200),
                'location' => 'Kennedy Space Center, Florida',
                'type' => 'rocket_launch',
                'visibility' => 'Live stream available worldwide, visible from Florida coast',
                'time' => '15:00',
                'duration' => '3 days mission',
                'is_recurring' => false,
                'image' => 'events/starship_launch.jpg',
            ],
            [
                'title' => 'Asteroid 2024 XY Close Approach',
                'description' => 'Asteroid 2024 XY will make a close but safe approach to Earth, passing within 0.05 lunar distances. This near-Earth asteroid provides scientists with a rare opportunity to study its composition and structure using ground-based telescopes.',
                'date' => Carbon::now()->addDays(15),
                'location' => 'Space (closest to Earth)',
                'type' => 'asteroid_flyby',
                'visibility' => 'Visible with medium telescopes (8+ inches)',
                'time' => '03:27',
                'duration' => '30 minutes peak visibility',
                'is_recurring' => false,
                'image' => 'events/asteroid_flyby.jpg',
            ],
            [
                'title' => 'International Space Station Bright Pass',
                'description' => 'The International Space Station will be making exceptionally bright passes over major cities, appearing as a fast-moving bright star across the sky. The ISS orbits Earth every 90 minutes and provides stunning viewing opportunities.',
                'date' => Carbon::now()->addDays(5),
                'location' => 'Major Cities Worldwide',
                'type' => 'other',
                'visibility' => 'Visible to naked eye, no equipment needed',
                'time' => '19:45',
                'duration' => '6 minutes pass duration',
                'is_recurring' => true,
                'image' => 'events/iss_pass.jpg',
            ],
            [
                'title' => 'Perseids Meteor Shower Peak',
                'description' => 'The Perseids meteor shower reaches its peak, producing up to 60 meteors per hour. These fast-moving meteors originate from Comet Swift-Tuttle and are known for their bright streaks and occasional fireballs.',
                'date' => Carbon::now()->addDays(60),
                'location' => 'Northern Hemisphere',
                'type' => 'meteor_shower',
                'visibility' => 'Best viewed from dark sky locations after midnight',
                'time' => '23:00',
                'duration' => 'Active all night (peak: 02:00-05:00)',
                'is_recurring' => true,
                'image' => 'events/perseids.jpg',
            ],
            [
                'title' => 'Jupiter at Opposition',
                'description' => 'Jupiter reaches opposition, appearing at its largest and brightest in Earth\'s sky. This is the perfect time to observe the gas giant\'s cloud bands, Great Red Spot, and its four largest moons through telescopes.',
                'date' => Carbon::now()->addDays(75),
                'location' => 'Worldwide',
                'type' => 'planet_alignment',
                'visibility' => 'Visible all night, rises at sunset',
                'time' => '20:00',
                'duration' => 'All night viewing',
                'is_recurring' => false,
                'image' => 'events/jupiter_opposition.jpg',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
        
        $this->command->info('Space events seeded successfully!');
    }
}