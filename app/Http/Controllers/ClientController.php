<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Http\Resources\ReservationResource;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Client::withCount('reservations');

        // Filtre par nom ou prénom
        if ($request->filled('nom')) {
            $query->where(function ($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->nom . '%')
                    ->orWhere('prenom', 'like', '%' . $request->nom . '%');
            });
        }

        // Filtre par email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        $clients = $query->orderBy('nom')->paginate(15);

        return ClientResource::collection($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'               => 'required|string|max:100',
            'prenom'            => 'required|string|max:100',
            'email'             => 'required|email|unique:clients,email',
            'telephone'         => 'nullable|string|max:20',
            'permis_numero'     => 'required|string|unique:clients,permis_numero',
            'permis_expiration' => 'required|date|after:today',
        ]);

        $client = Client::create($validated);

        return new ClientResource($client);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->loadCount('reservations');
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nom'               => 'sometimes|string|max:100',
            'prenom'            => 'sometimes|string|max:100',
            'email'             => 'sometimes|email|unique:clients,email,' . $client->id,
            'telephone'         => 'nullable|string|max:20',
            'permis_numero'     => 'sometimes|string|unique:clients,permis_numero,' . $client->id,
            'permis_expiration' => 'sometimes|date',
        ]);

        $client->update($validated);

        return new ClientResource($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        if ($client->reservations()->whereIn('statut', ['en_attente', 'confirmee', 'en_cours'])->exists()) {
            return response()->json([
                'message' => 'Impossible de supprimer un client ayant des réservations actives.'
            ], 409);
        }

        $client->delete();

        return response()->json(['message' => 'Client supprimé.'], 200);
    }

    /**
     * @param Client $client
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * Route imbriquée : GET /api/clients/{client}/reservations
     */
    public function reservations(Client $client)
    {
        $reservations = $client->reservations()
            ->with(['voiture.categorie', 'paiement'])
            ->orderByDesc('date_debut')
            ->paginate(15);

        return ReservationResource::collection($reservations);
    }
}
