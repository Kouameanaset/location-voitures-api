<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'nom'               => 'Tremblay',
                'prenom'            => 'Sophie',
                'email'             => 'sophie.tremblay@email.com',
                'telephone'         => '514-555-0101',
                'permis_numero'     => 'T1234-567890-00',
                'permis_expiration' => '2028-06-15',
            ],
            [
                'nom'               => 'Dubois',
                'prenom'            => 'Marc',
                'email'             => 'marc.dubois@email.com',
                'telephone'         => '438-555-0102',
                'permis_numero'     => 'D9876-543210-00',
                'permis_expiration' => '2027-03-22',
            ],
            [
                'nom'               => 'Fontaine',
                'prenom'            => 'Léa',
                'email'             => 'lea.fontaine@email.com',
                'telephone'         => '450-555-0103',
                'permis_numero'     => 'F4567-890123-00',
                'permis_expiration' => '2029-11-30',
            ],
            [
                'nom'               => 'Benali',
                'prenom'            => 'Ahmed',
                'email'             => 'ahmed.benali@email.com',
                'telephone'         => '514-555-0104',
                'permis_numero'     => 'B2345-678901-00',
                'permis_expiration' => '2026-08-10',
            ],
            [
                'nom'               => 'Gagnon',
                'prenom'            => 'Julie',
                'email'             => 'julie.gagnon@email.com',
                'telephone'         => '418-555-0105',
                'permis_numero'     => 'G6789-012345-00',
                'permis_expiration' => '2030-01-05',
            ],
            [
                'nom'               => 'Lapointe',
                'prenom'            => 'Nicolas',
                'email'             => 'nicolas.lapointe@email.com',
                'telephone'         => '819-555-0106',
                'permis_numero'     => 'L1122-334455-00',
                'permis_expiration' => '2027-09-18',
            ],
        ];

        foreach ($clients as $data) {
            Client::create($data);
        }
    }
}
