<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * modele categorie
 */
class Categorie extends Model
{

    protected $fillable = [
        'nom',
        'description',
        'tarif_journalier',
    ];

    protected $casts = [
        'tarif_journalier' => 'float',
    ];

    /**
     * voitures
     */
    public function voitures()
    {
        return $this->hasMany(Voiture::class);
    }
}
