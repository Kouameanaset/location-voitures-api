<?php

namespace Database\Seeders;

use App\Models\Voiture;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoitureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voitures = [
            // Économique (categorie_id: 1)
            ['categorie_id' => 1, 'marque' => 'Toyota',     'modele' => 'Yaris',      'annee' => 2022, 'immatriculation' => 'ABC-1234', 'couleur' => 'Blanc',   'kilometrage' => 18000,  'statut' => 'disponible'],
            ['categorie_id' => 1, 'marque' => 'Hyundai',    'modele' => 'Accent',     'annee' => 2023, 'immatriculation' => 'DEF-2345', 'couleur' => 'Gris',    'kilometrage' => 9500,   'statut' => 'disponible'],
            ['categorie_id' => 1, 'marque' => 'Kia',        'modele' => 'Rio',        'annee' => 2021, 'immatriculation' => 'GHI-3456', 'couleur' => 'Rouge',   'kilometrage' => 32000,  'statut' => 'maintenance'],

            // Intermédiaire (categorie_id: 2)
            ['categorie_id' => 2, 'marque' => 'Toyota',     'modele' => 'Corolla',    'annee' => 2023, 'immatriculation' => 'JKL-4567', 'couleur' => 'Noir',    'kilometrage' => 14000,  'statut' => 'louee'],
            ['categorie_id' => 2, 'marque' => 'Honda',      'modele' => 'Civic',      'annee' => 2022, 'immatriculation' => 'MNO-5678', 'couleur' => 'Bleu',    'kilometrage' => 21000,  'statut' => 'disponible'],
            ['categorie_id' => 2, 'marque' => 'Mazda',      'modele' => '3',          'annee' => 2024, 'immatriculation' => 'PQR-6789', 'couleur' => 'Rouge',   'kilometrage' => 4500,   'statut' => 'disponible'],

            // VUS compact (categorie_id: 3)
            ['categorie_id' => 3, 'marque' => 'Honda',      'modele' => 'CR-V',       'annee' => 2023, 'immatriculation' => 'STU-7890', 'couleur' => 'Argent',  'kilometrage' => 16000,  'statut' => 'disponible'],
            ['categorie_id' => 3, 'marque' => 'Ford',       'modele' => 'Escape',     'annee' => 2022, 'immatriculation' => 'VWX-8901', 'couleur' => 'Blanc',   'kilometrage' => 28000,  'statut' => 'louee'],
            ['categorie_id' => 3, 'marque' => 'Nissan',     'modele' => 'Rogue',      'annee' => 2024, 'immatriculation' => 'YZA-9012', 'couleur' => 'Gris',    'kilometrage' => 6000,   'statut' => 'disponible'],

            // VUS pleine grandeur (categorie_id: 4)
            ['categorie_id' => 4, 'marque' => 'Chevrolet',  'modele' => 'Tahoe',      'annee' => 2023, 'immatriculation' => 'BCD-0123', 'couleur' => 'Noir',    'kilometrage' => 22000,  'statut' => 'disponible'],
            ['categorie_id' => 4, 'marque' => 'Ford',       'modele' => 'Expedition', 'annee' => 2022, 'immatriculation' => 'EFG-1357', 'couleur' => 'Blanc',   'kilometrage' => 35000,  'statut' => 'disponible'],

            // Luxe (categorie_id: 5)
            ['categorie_id' => 5, 'marque' => 'BMW',        'modele' => 'Série 5',    'annee' => 2024, 'immatriculation' => 'HIJ-2468', 'couleur' => 'Noir',    'kilometrage' => 8000,   'statut' => 'disponible'],
            ['categorie_id' => 5, 'marque' => 'Mercedes',   'modele' => 'Classe C',   'annee' => 2023, 'immatriculation' => 'KLM-3579', 'couleur' => 'Argent',  'kilometrage' => 12000,  'statut' => 'disponible'],
        ];

        foreach ($voitures as $data) {
            Voiture::create($data);
        }
    }
}
