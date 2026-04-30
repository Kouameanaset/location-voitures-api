<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategorieResource;
use App\Http\Resources\VoitureResource;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Categorie::withCount('voitures');

        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }

        $categories = $query->orderBy('nom')->paginate(15);

        return CategorieResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'              => 'required|string|max:100',
            'description'      => 'nullable|string',
            'tarif_journalier' => 'required|numeric|min:0',
        ]);

        $categorie = Categorie::create($validated);

        return new CategorieResource($categorie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        $categorie->loadCount('voitures');
        return new CategorieResource($categorie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        $validated = $request->validate([
            'nom'              => 'sometimes|string|max:100',
            'description'      => 'nullable|string',
            'tarif_journalier' => 'sometimes|numeric|min:0',
        ]);

        $categorie->update($validated);

        return new CategorieResource($categorie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        if ($categorie->voitures()->exists()) {
            return response()->json([
                'message' => 'Impossible de supprimer une catégorie qui contient des voitures.'
            ], 409);
        }

        $categorie->delete();

        return response()->json(['message' => 'Catégorie supprimée.'], 200);
    }

    /**
     * @param Categorie $categorie
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * Route imbriquée : GET /api/categories/{categorie}/voitures
     */
    public function voitures(Categorie $categorie)
    {
        $voitures = $categorie->voitures()
            ->with('categorie')
            ->paginate(15);

        return VoitureResource::collection($voitures);
    }
}
