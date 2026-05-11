<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Http\Resources\VoitureResource;
use App\Models\Voiture;
use Illuminate\Http\Request;

/**
 * controller voiture
 */
class VoitureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Voiture::with('categorie');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('marque', 'like', '%' . $request->search . '%')
                    ->orWhere('modele', 'like', '%' . $request->search . '%');
            });
        }

        $voitures = $query->orderBy('marque')->paginate(15);

        return VoitureResource::collection($voitures);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categorie_id'    => 'required|exists:categories,id',
            'marque'          => 'required|string|max:100',
            'modele'          => 'required|string|max:100',
            'annee'           => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'immatriculation' => 'required|string|unique:voitures,immatriculation',
            'couleur'         => 'nullable|string|max:50',
            'kilometrage'     => 'nullable|integer|min:0',
            'statut'          => 'nullable|in:disponible,louee,maintenance,hors_service',
        ]);

        $voiture = Voiture::create($validated);
        $voiture->load('categorie');

        return new VoitureResource($voiture);
    }

    /**
     * Display the specified resource.
     */
    public function show(Voiture $voiture)
    {
        $voiture->load('categorie');
        return new VoitureResource($voiture);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voiture $voiture)
    {
        $validated = $request->validate([
            'categorie_id'    => 'sometimes|exists:categories,id',
            'marque'          => 'sometimes|string|max:100',
            'modele'          => 'sometimes|string|max:100',
            'annee'           => 'sometimes|integer|min:1990|max:' . (date('Y') + 1),
            'immatriculation' => 'sometimes|string|unique:voitures,immatriculation,' . $voiture->id,
            'couleur'         => 'nullable|string|max:50',
            'kilometrage'     => 'nullable|integer|min:0',
            'statut'          => 'nullable|in:disponible,louee,maintenance,hors_service',
        ]);

        $voiture->update($validated);
        $voiture->load('categorie');

        return new VoitureResource($voiture);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voiture $voiture)
    {
        if ($voiture->reservations()->whereIn('statut', ['confirmee', 'en_cours'])->exists()) {
            return response()->json([
                'message' => 'Impossible de supprimer une voiture avec une réservation active.'
            ], 409);
        }

        $voiture->delete();

        return response()->json(['message' => 'Voiture supprimée.'], 200);
    }

    /**
     * Route imbriquée : GET /api/voitures/{voiture}/reservations
     */
    public function reservations(Voiture $voiture)
    {
        $reservations = $voiture->reservations()
            ->with(['client', 'paiement'])
            ->orderByDesc('date_debut')
            ->paginate(15);

        return ReservationResource::collection($reservations);
    }
}
