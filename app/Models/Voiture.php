<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modele voiture
 */
class Voiture extends Model
{

    protected $fillable = [
        'categorie_id',
        'marque',
        'modele',
        'annee',
        'immatriculation',
        'couleur',
        'kilometrage',
        'statut',
    ];

    protected $casts = [
        'annee'       => 'integer',
        'kilometrage' => 'integer',
    ];

    /**
     * categorie
     */
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    /**
     * reservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
