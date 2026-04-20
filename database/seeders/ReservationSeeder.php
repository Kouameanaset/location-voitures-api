<?php

namespace Database\Seeders;

use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reservations = [
            [
                'client_id'  => 1, // Sophie Tremblay
                'voiture_id' => 5, // Honda Civic
                'date_debut' => '2026-04-14',
                'date_fin'   => '2026-04-18',
                //'prix_total' => 220.00, // 4 jours x 55$
                'statut'     => 'confirmee',
                'notes'      => 'Siège bébé requis.',
            ],
            [
                'client_id'  => 2, // Marc Dubois
                'voiture_id' => 7, // Honda CR-V
                'date_debut' => '2026-04-10',
                'date_fin'   => '2026-04-13',
                //'prix_total' => 225.00, // 3 jours x 75$
                'statut'     => 'terminee',
                'notes'      => null,
            ],
            [
                'client_id'  => 3, // Léa Fontaine
                'voiture_id' => 8, // Ford Escape
                'date_debut' => '2026-04-13',
                'date_fin'   => '2026-04-15',
                //'prix_total' => 150.00, // 2 jours x 75$
                'statut'     => 'en_cours',
                'notes'      => 'Retour prévu à 17h.',
            ],
            [
                'client_id'  => 4, // Ahmed Benali
                'voiture_id' => 6, // Mazda 3
                'date_debut' => '2026-04-12',
                'date_fin'   => '2026-04-14',
                //'prix_total' => 110.00, // 2 jours x 55$
                'statut'     => 'annulee',
                'notes'      => 'Annulé par le client.',
            ],
            [
                'client_id'  => 5, // Julie Gagnon
                'voiture_id' => 10, // Chevrolet Tahoe
                'date_debut' => '2026-04-20',
                'date_fin'   => '2026-04-25',
                //'prix_total' => 475.00, // 5 jours x 95$
                'statut'     => 'confirmee',
                'notes'      => 'Voyage en famille.',
            ],
            [
                'client_id'  => 6, // Nicolas Lapointe
                'voiture_id' => 12, // BMW Série 5
                'date_debut' => '2026-04-22',
                'date_fin'   => '2026-04-24',
                //'prix_total' => 300.00, // 2 jours x 150$
                'statut'     => 'en_attente',
                'notes'      => null,
            ],
        ];

        foreach ($reservations as $data) {
            $reservation = Reservation::create($data);
            $reservation->load('voiture.categorie');

            // Créer un paiement pour les réservations confirmées ou terminées
            if (in_array($data['statut'], ['confirmee', 'terminee', 'en_cours'])) {
                Paiement::create([
                    'reservation_id' => $reservation->id,
                    'montant'        => $reservation->prix_total,
                    'methode'        => 'carte',
                    'statut'         => 'complete',
                    'date_paiement'  => now()->subDays(rand(1, 5)),
                ]);
            }
        }
    }
}
