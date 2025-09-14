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
                'title' => 'Geminids Meteor Shower 2024',
                'description' => 'The Geminids meteor shower peaked on December 14, 2024. Known as the best meteor shower of the year, it produced up to 120 multicolored meteors per hour at its peak.',
                'date' => Carbon::create(2024, 12, 14),
                'location' => 'Worldwide',
                'type' => 'meteor_shower',
                'visibility' => 'Best viewed from Northern Hemisphere after 21:00',
                'time' => '22:00',
                'duration' => 'All night (peak: 02:00-04:00)',
                'is_recurring' => true,
                'image' => 'events/geminids.jpg',
            ],
            [
                'title' => 'Total Solar Eclipse April 2024',
                'description' => 'A total solar eclipse occurred on April 8, 2024, when the Moon completely blocked the Sun across North America, briefly turning day into night.',
                'date' => Carbon::create(2024, 4, 8),
                'location' => 'North America',
                'type' => 'eclipse',
                'visibility' => 'Path of totality across Mexico, US, and Canada',
                'time' => '14:30',
                'duration' => '4 minutes totality',
                'is_recurring' => false,
                'image' => 'events/solar_eclipse.jpg',
            ],
            [
                'title' => 'Mars Opposition 2024',
                'description' => 'On January 16, 2024, Mars reached opposition, appearing brightest and largest in the night sky, making it the best time for telescopic observation.',
                'date' => Carbon::create(2024, 1, 16),
                'location' => 'Worldwide',
                'type' => 'planet_alignment',
                'visibility' => 'Visible worldwide after sunset, highest at midnight',
                'time' => '21:00',
                'duration' => 'All night (best viewing: 22:00-02:00)',
                'is_recurring' => false,
                'image' => 'events/mars_opposition.jpg',
            ],
            [
                'title' => 'Asteroid 2023 DZ2 Close Approach',
                'description' => 'On March 25, 2023, asteroid 2023 DZ2 safely passed within 0.08 lunar distances of Earth, giving astronomers a rare chance to study a near-Earth asteroid.',
                'date' => Carbon::create(2023, 3, 25),
                'location' => 'Near Earth',
                'type' => 'asteroid_flyby',
                'visibility' => 'Visible with medium telescopes (8+ inches)',
                'time' => '03:27',
                'duration' => '30 minutes peak visibility',
                'is_recurring' => false,
                'image' => 'events/asteroid_flyby.jpg',
            ],
            [
                'title' => 'Perseids Meteor Shower 2024',
                'description' => 'The Perseids peaked on August 12, 2024, producing up to 60 meteors per hour, famous for bright streaks and occasional fireballs.',
                'date' => Carbon::create(2024, 8, 12),
                'location' => 'Northern Hemisphere',
                'type' => 'meteor_shower',
                'visibility' => 'Best viewed from dark sky locations after midnight',
                'time' => '23:00',
                'duration' => 'Active all night (peak: 02:00-05:00)',
                'is_recurring' => true,
                'image' => 'events/perseids.jpg',
            ],
            [
                'title' => 'Jupiter at Opposition 2023',
                'description' => 'On November 3, 2023, Jupiter reached opposition, shining its brightest and largest in the night sky, offering stunning telescopic views.',
                'date' => Carbon::create(2023, 11, 3),
                'location' => 'Worldwide',
                'type' => 'planet_alignment',
                'visibility' => 'Visible all night, rises at sunset',
                'time' => '20:00',
                'duration' => 'All night viewing',
                'is_recurring' => false,
                'image' => 'events/jupiter_opposition.jpg',
            ],
            [
                'title' => 'Lunar Eclipse May 2024',
                'description' => 'On May 5, 2024, a penumbral lunar eclipse occurred, visible across Europe, Africa, Asia, and Australia.',
                'date' => Carbon::create(2024, 5, 5),
                'location' => 'Europe, Africa, Asia, Australia',
                'type' => 'eclipse',
                'visibility' => 'Visible where Moon was above horizon',
                'time' => '17:14',
                'duration' => '4 hours 18 minutes',
                'is_recurring' => false,
                'image' => 'events/lunar_eclipse.jpg',
            ],
            [
                'title' => 'Quadrantids Meteor Shower 2024',
                'description' => 'The Quadrantids peaked on January 4, 2024, with about 40 meteors per hour, known for their sharp peak and bright fireballs.',
                'date' => Carbon::create(2024, 1, 4),
                'location' => 'Northern Hemisphere',
                'type' => 'meteor_shower',
                'visibility' => 'Best viewed before dawn in dark sky locations',
                'time' => '04:00',
                'duration' => '6 hours peak activity',
                'is_recurring' => true,
                'image' => 'events/quadrantids.jpg',
            ],
            [
                'title' => 'Lyrids Meteor Shower 2024',
                'description' => 'The Lyrids peaked on April 22, 2024, producing around 18 meteors per hour, sometimes with bright outbursts.',
                'date' => Carbon::create(2024, 4, 22),
                'location' => 'Northern Hemisphere',
                'type' => 'meteor_shower',
                'visibility' => 'Best viewed after midnight in dark locations',
                'time' => '02:00',
                'duration' => 'Active for several nights',
                'is_recurring' => true,
                'image' => 'events/lyrids.jpg',
            ],
            [
                'title' => 'Saturn at Opposition 2024',
                'description' => 'On September 8, 2024, Saturn reached opposition, appearing brightest with its rings well visible for telescopic observation.',
                'date' => Carbon::create(2024, 9, 8),
                'location' => 'Worldwide',
                'type' => 'planet_alignment',
                'visibility' => 'Visible all night, best viewing around midnight',
                'time' => '21:30',
                'duration' => 'All night observation',
                'is_recurring' => false,
                'image' => 'events/saturn_opposition.jpg',
            ],
            [
                'title' => 'Supernova SN 1987A',
                'description' => 'Discovered on February 23, 1987, in the Large Magellanic Cloud, SN 1987A was the closest observed supernova since Kepler\'s Supernova. It provided astronomers with invaluable data about stellar evolution and neutrino emissions.',
                'date' => Carbon::create(1987, 2, 23),
                'location' => 'Large Magellanic Cloud (near Milky Way)',
                'type' => 'supernova',
                'visibility' => 'Visible to the naked eye in Southern Hemisphere',
                'time' => '02:35',
                'duration' => 'Several months of visibility',
                'is_recurring' => false,
                'image' => 'events/sn1987a.jpeg',
            ],
            [
                'title' => 'Supernova SN 2023zkd',
                'description' => 'In July 2023, astronomers observed SN 2023zkd, a rare supernova triggered by the interaction between a star and a black hole, providing new insights into cosmic evolution.',
                'date' => Carbon::create(2023, 7, 12),
                'location' => 'Milky Way Galaxy',
                'type' => 'supernova',
                'visibility' => 'Visible with powerful telescopes',
                'time' => '23:15',
                'duration' => 'Weeks of visibility',
                'is_recurring' => false,
                'image' => 'events/sn2023zkd.jpg',
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
        
        $this->command->info('Seeded 12 real astronomical events (past only, no rocket events).');
    }
}