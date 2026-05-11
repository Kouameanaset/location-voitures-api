<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoitureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'marque'          => $this->marque,
            'modele'          => $this->modele,
            'annee'           => $this->annee,
            'immatriculation' => $this->immatriculation,
            'couleur'         => $this->couleur,
            'kilometrage'     => $this->kilometrage,
            'statut'          => $this->statut,
            'categorie'       => new CategorieResource($this->whenLoaded('categorie')),
            'created_at'      => $this->created_at?->format('Y-m-d'),
        ];
    }
}
