<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * modele paiement
 */
class Paiement extends Model
{

    protected $fillable = [
        'reservation_id',
        'montant',
        'methode',
        'statut',
        'date_paiement',
    ];

    protected $casts = [
        'montant'       => 'float',
        'date_paiement' => 'datetime',
    ];

    /**
     * reservation
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
