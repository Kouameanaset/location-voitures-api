<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modele reservation
 */
class Reservation extends Model
{

    protected $fillable = [
        'client_id',
        'voiture_id',
        'date_debut',
        'date_fin',
        'statut',
        'notes',
    ];

    protected $appends = ['prix_total'];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    /**
     * client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * voiture
     */
    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }

    /**
     * paiement
     */
    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

    /**
     * prix total
     */
    protected function prixTotal(): Attribute
    {
        return Attribute::make(
            get: fn() =>
            $this->date_debut && $this->date_fin && $this->voiture && $this->voiture->categorie
                ? max(1, $this->date_debut->diffInDays($this->date_fin))
                * $this->voiture->categorie->tarif_journalier
                : 0
        );
    }

}
