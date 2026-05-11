<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaiementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'montant'       => $this->montant,
            'methode'       => $this->methode,
            'statut'        => $this->statut,
            'date_paiement' => $this->date_paiement?->format('Y-m-d'),
            'reservation'   => new ReservationResource($this->whenLoaded('reservation')),
            'created_at'    => $this->created_at?->format('Y-m-d'),
        ];
    }
}
