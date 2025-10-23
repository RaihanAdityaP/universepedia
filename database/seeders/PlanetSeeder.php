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
                'name' => 'Merkurius',
                'description' => 'Planet terkecil di tata surya kita dan yang paling dekat dengan Matahari. Merkurius tidak memiliki atmosfer dan mengalami variasi suhu yang ekstrem.',
                'size' => '4.879 km diameter',
                'distance' => '57,9 juta km dari Matahari',
                'created_by' => 1,
            ],
            [
                'name' => 'Venus',
                'description' => 'Sering disebut kembaran Bumi karena ukurannya yang hampir sama. Venus memiliki atmosfer tebal dan beracun yang memerangkap panas, menjadikannya planet terpanas.',
                'size' => '12.104 km diameter',
                'distance' => '108,2 juta km dari Matahari',
                'created_by' => 1,
            ],
            [
                'name' => 'Bumi',
                'description' => 'Planet tempat tinggal kita, satu-satunya dunia yang diketahui memiliki kehidupan. Bumi memiliki atmosfer pelindung dan air cair di permukaannya.',
                'size' => '12.742 km diameter',
                'distance' => '149,6 juta km dari Matahari',
                'created_by' => 1,
            ],
            [
                'name' => 'Mars',
                'description' => 'Planet Merah, dinamai karena penampilannya yang kemerahan. Mars memiliki gunung berapi terbesar dan ngarai terdalam di tata surya.',
                'size' => '6.779 km diameter',
                'distance' => '227,9 juta km dari Matahari',
                'created_by' => 1,
            ],
            [
                'name' => 'Jupiter',
                'description' => 'Planet terbesar di tata surya. Jupiter adalah raksasa gas dengan Bintik Merah Besar, badai raksasa yang lebih besar dari Bumi.',
                'size' => '139.820 km diameter',
                'distance' => '778,5 juta km dari Matahari',
                'created_by' => 1,
            ],
            [
                'name' => 'Saturnus',
                'description' => 'Terkenal dengan sistem cincin spektakulernya yang terdiri dari partikel es dan batu. Saturnus adalah raksasa gas dengan banyak bulan.',
                'size' => '116.460 km diameter',
                'distance' => '1,43 miliar km dari Matahari',
                'created_by' => 1,
            ],
            [
                'name' => 'Uranus',
                'description' => 'Raksasa es yang berputar dengan posisi miring pada sisinya. Uranus berwarna biru kehijauan karena kandungan metana di atmosfernya.',
                'size' => '50.724 km diameter',
                'distance' => '2,87 miliar km dari Matahari',
                'created_by' => 1,
            ],
            [
                'name' => 'Neptunus',
                'description' => 'Planet dengan angin tercepat di tata surya, bahkan melebihi kecepatan suara. Neptunus adalah raksasa es berwarna biru tua.',
                'size' => '49.244 km diameter',
                'distance' => '4,50 miliar km dari Matahari',
                'created_by' => 1,
            ],
        ];

        foreach ($planets as $planet) {
            Planet::create($planet);
        }
    }
}