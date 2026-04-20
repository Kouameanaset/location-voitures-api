<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voiture extends Model
{
    use HasFactory;

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

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
