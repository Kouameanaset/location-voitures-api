<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'nom'              => $this->nom,
            'description'      => $this->description,
            'tarif_journalier' => $this->tarif_journalier,
            'nb_voitures'      => $this->whenCounted('voitures'),
            'created_at'       => $this->created_at?->format('Y-m-d'),
        ];
    }
}
