<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaiementResource;
use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;

/**
 * Controller paiement
 */
class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Paiement::with('reservation.client');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('methode')) {
            $query->where('methode', $request->methode);
        }

        $paiements = $query->orderByDesc('created_at')->paginate(15);

        return PaiementResource::collection($paiements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'montant'        => 'required|numeric|min:0',
            'methode'        => 'required|in:carte,comptant,virement,cheque',
        ]);

        $existant = Paiement::where('reservation_id', $validated['reservation_id'])
            ->where('statut', 'complete')
            ->exists();

        if ($existant) {
            return response()->json([
                'message' => 'Un paiement a déjà été effectué pour cette réservation.'
            ], 409);
        }

        $validated['statut']         = 'complete';
        $validated['date_paiement']  = now();

        $paiement = Paiement::create($validated);

        $reservation = Reservation::find($validated['reservation_id']);
        if ($reservation->statut === 'en_attente') {
            $reservation->update(['statut' => 'confirmee']);
        }

        $paiement->load('reservation.client');

        return new PaiementResource($paiement);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paiement $paiement)
    {
        $paiement->load('reservation.client');
        return new PaiementResource($paiement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paiement $paiement)
    {
        $validated = $request->validate([
            'statut'  => 'sometimes|in:en_attente,complete,rembourse,echoue',
            'methode' => 'sometimes|in:carte,comptant,virement,cheque',
        ]);

        $paiement->update($validated);

        return new PaiementResource($paiement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paiement $paiement)
    {
        if ($paiement->statut === 'complete') {
            return response()->json([
                'message' => 'Impossible de supprimer un paiement complété. Utilisez un remboursement.'
            ], 409);
        }

        $paiement->delete();

        return response()->json(['message' => 'Paiement supprimé.'], 200);
    }
}
