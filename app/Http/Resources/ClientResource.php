<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'nom'               => $this->nom,
            'prenom'            => $this->prenom,
            'email'             => $this->email,
            'telephone'         => $this->telephone,
            'permis_numero'     => $this->permis_numero,
            'permis_expiration' => $this->permis_expiration?->format('Y-m-d'),
            'nb_reservations'   => $this->whenCounted('reservations'),
            'created_at'        => $this->created_at?->format('Y-m-d'),
        ];
    }
}
