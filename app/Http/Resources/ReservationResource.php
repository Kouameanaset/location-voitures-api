<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'date_debut' => $this->date_debut?->format('Y-m-d'),
            'date_fin'   => $this->date_fin?->format('Y-m-d'),
            'nb_jours'   => $this->date_debut && $this->date_fin
                ? $this->date_debut->diffInDays($this->date_fin)
                : null,
            'prix_total' => $this->prix_total,
            'statut'     => $this->statut,
            'notes'      => $this->notes,
            'client'     => new ClientResource($this->whenLoaded('client')),
            'voiture'    => new VoitureResource($this->whenLoaded('voiture')),
            'paiement'   => new PaiementResource($this->whenLoaded('paiement')),
            'created_at' => $this->created_at?->format('Y-m-d'),
        ];
    }
}
