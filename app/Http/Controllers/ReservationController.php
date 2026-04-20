<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Voiture;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['client', 'voiture.categorie', 'paiement']);

        // Filtre par statut (ex: ?statut=confirmee)
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Filtre par date de début (ex: ?date_debut=2026-05-01)
        if ($request->filled('date_debut')) {
            $query->where('date_debut', '>=', $request->date_debut);
        }

        // Filtre par client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filtre par voiture
        if ($request->filled('voiture_id')) {
            $query->where('voiture_id', $request->voiture_id);
        }

        $reservations = $query->orderByDesc('date_debut')->paginate(15);

        return ReservationResource::collection($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'voiture_id' => 'required|exists:voitures,id',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin'   => 'required|date|after:date_debut',
            'notes'      => 'nullable|string',
        ]);

        // Vérifier que la voiture est disponible
        $voiture = Voiture::findOrFail($validated['voiture_id']);

        if ($voiture->statut !== 'disponible') {
            return response()->json([
                'message' => 'Cette voiture n\'est pas disponible à la location.'
            ], 422);
        }

        // Vérifier qu'il n'y a pas de conflit de dates
        $conflit = Reservation::where('voiture_id', $validated['voiture_id'])
            ->whereNotIn('statut', ['annulee', 'terminee'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('date_debut', [$validated['date_debut'], $validated['date_fin']])
                    ->orWhereBetween('date_fin', [$validated['date_debut'], $validated['date_fin']])
                    ->orWhere(function ($q2) use ($validated) {
                        $q2->where('date_debut', '<=', $validated['date_debut'])
                            ->where('date_fin', '>=', $validated['date_fin']);
                    });
            })->exists();

        if ($conflit) {
            return response()->json([
                'message' => 'Cette voiture est déjà réservée pour ces dates.'
            ], 422);
        }

        // Calculer le prix total automatiquement
        $nbJours = (int) Carbon::parse($validated['date_debut'])
            ->diffInDays(Carbon::parse($validated['date_fin']));

        //$validated['prix_total'] = $nbJours * $voiture->categorie->tarif_journalier;
        $validated['statut']     = 'en_attente';

        $reservation = Reservation::create($validated);
        $reservation->load(['client', 'voiture.categorie', 'paiement']);

        return new ReservationResource($reservation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['client', 'voiture.categorie', 'paiement']);
        return new ReservationResource($reservation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'statut' => 'sometimes|in:en_attente,confirmee,en_cours,terminee,annulee',
            'notes'  => 'nullable|string',
        ]);

        // Mettre à jour le statut de la voiture selon la réservation
        if (isset($validated['statut'])) {
            $voiture = $reservation->voiture;

            if ($validated['statut'] === 'en_cours') {
                $voiture->update(['statut' => 'louee']);
            } elseif (in_array($validated['statut'], ['terminee', 'annulee'])) {
                $voiture->update(['statut' => 'disponible']);
            }
        }

        $reservation->update($validated);
        $reservation->load(['client', 'voiture.categorie', 'paiement']);

        return new ReservationResource($reservation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        if (in_array($reservation->statut, ['en_cours'])) {
            return response()->json([
                'message' => 'Impossible de supprimer une réservation en cours.'
            ], 409);
        }

        $reservation->delete();

        return response()->json(['message' => 'Réservation supprimée.'], 200);
    }
}
