<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Planet;
use App\Models\Event;
use Database\Seeders\PlanetSeeder;
use Database\Seeders\EventSeeder;

class AutoSeedData extends Command
{
    protected $signature = 'universepedia:seed';
    protected $description = 'Auto-seed planets and events data if not exists';

    public function handle()
    {
        $this->info('Checking Universepedia data...');

        // Check planets
        if (Planet::count() === 0) {
            $this->info('No planets found. Seeding planets...');
            $this->call('db:seed', ['--class' => 'PlanetSeeder']);
            $this->info('Planets seeded successfully!');
        } else {
            $this->info('Planets already exist (' . Planet::count() . ' planets)');
        }

        // Check events
        if (Event::count() === 0) {
            $this->info('No events found. Seeding events...');
            $this->call('db:seed', ['--class' => 'EventSeeder']);
            $this->info('Events seeded successfully!');
        } else {
            $this->info('Events already exist (' . Event::count() . ' events)');
        }

        $this->info('Universepedia data check completed!');
    }
}