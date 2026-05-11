<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * modele client
 */
class Client extends Model
{

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'permis_numero',
        'permis_expiration',
    ];

    protected $casts = [
        'permis_expiration' => 'date',
    ];

    /**
     * reservations
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
