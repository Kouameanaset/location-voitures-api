<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'voiture_id',
        'date_debut',
        'date_fin',
        //'prix_total',
        'statut',
        'notes',
    ];

    protected $appends = ['prix_total'];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        //'prix_total' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function voiture()
    {
        return $this->belongsTo(Voiture::class);
    }

    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }

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
