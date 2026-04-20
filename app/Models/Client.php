<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

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

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
