<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'tarif_journalier',
    ];

    protected $casts = [
        'tarif_journalier' => 'decimal:2',
    ];

    public function voitures()
    {
        return $this->hasMany(Voiture::class);
    }
}
