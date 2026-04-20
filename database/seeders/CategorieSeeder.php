<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nom'              => 'Économique',
                'description'      => 'Petites voitures économiques, idéales pour la ville.',
                'tarif_journalier' => 35.00,
            ],
            [
                'nom'              => 'Intermédiaire',
                'description'      => 'Berlines confortables pour les trajets quotidiens.',
                'tarif_journalier' => 55.00,
            ],
            [
                'nom'              => 'VUS compact',
                'description'      => 'VUS compact, polyvalent et spacieux.',
                'tarif_journalier' => 75.00,
            ],
            [
                'nom'              => 'VUS pleine grandeur',
                'description'      => 'Grand VUS, idéal pour les familles et longs voyages.',
                'tarif_journalier' => 95.00,
            ],
            [
                'nom'              => 'Luxe',
                'description'      => 'Véhicules haut de gamme pour une expérience premium.',
                'tarif_journalier' => 150.00,
            ],
        ];

        foreach ($categories as $data) {
            Categorie::create($data);
        }
    }
}
