# Location de voitures — API

API REST Laravel pour gérer une agence de location de voitures : catégories de véhicules, voitures, clients, réservations et paiements. Elle est consommée par l'interface React du dépôt [location-voiture-front](https://github.com/Kouameanaset/location-voiture-front).

## Technologies

- PHP 8.3+, Laravel 13, Eloquent ORM
- MySQL 8.4 (via Laravel Sail) ou SQLite en local
- Laravel Sanctum installé (seule la route `/api/user` est protégée ; les autres ressources sont ouvertes)

## Fonctionnalités

- CRUD complet (`apiResource`) pour les catégories, clients, voitures, réservations et paiements.
- Routes imbriquées : réservations d'un client, réservations d'une voiture, voitures d'une catégorie.
- Création d'une réservation avec validation : client et voiture existants, date de début aujourd'hui ou plus tard, date de fin après la date de début.
- **Règles métier** à la création d'une réservation :
  - refus si la voiture n'est pas au statut `disponible` ;
  - refus si les dates chevauchent une réservation non annulée et non terminée de la même voiture.
- Évolution des statuts d'une réservation (`en_attente`, `confirmee`, `en_cours`, `terminee`, `annulee`) : la voiture passe à `louee` quand la réservation est en cours et redevient `disponible` quand elle est terminée ou annulée.
- Liste des réservations filtrable (statut, date de début, client, voiture) et paginée (15 par page).
- Recherche de voitures par marque ou modèle.
- Réponses formatées avec des API Resources.
- Seeders pour les catégories, voitures, clients et réservations.

## Modèle de données

| Table | Colonnes principales |
| --- | --- |
| `categories` | nom, description, tarif_journalier |
| `voitures` | categorie_id, marque, modele, annee, immatriculation (unique), couleur, kilometrage, statut (`disponible`, `louee`, `maintenance`, `hors_service`) |
| `clients` | informations du client |
| `reservations` | client_id, voiture_id, date_debut, date_fin, statut, notes |
| `paiements` | reservation_id, montant, methode (`carte`, `comptant`, `virement`, `cheque`), statut (`en_attente`, `complete`, `rembourse`, `echoue`), date_paiement |

## Installation

Prérequis : PHP 8.3+ et Composer, ou Docker pour utiliser Laravel Sail.

```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Avec Sail (MySQL) :

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
```

Par défaut, `.env.example` utilise SQLite. Pour MySQL avec Sail, ajustez les variables `DB_*` dans `.env`.

## Endpoints principaux

| Méthode | Route | Description |
| --- | --- | --- |
| GET, POST | `/api/reservations` | Lister (filtres, pagination) ou créer une réservation |
| GET, PUT, DELETE | `/api/reservations/{id}` | Consulter, modifier le statut ou supprimer |
| GET | `/api/clients/{id}/reservations` | Réservations d'un client |
| GET | `/api/voitures/{id}/reservations` | Réservations d'une voiture |
| GET | `/api/categories/{id}/voitures` | Voitures d'une catégorie |

Les ressources `categories`, `clients`, `voitures` et `paiements` suivent le même schéma REST.

## Limites connues

- Les routes de ressources ne sont pas encore protégées par l'authentification.
- Les tests automatisés se limitent aux tests d'exemple de Laravel.

## Projet scolaire

Projet réalisé dans le cadre du programme Techniques de l'informatique, Cégep Saint-Jean-sur-Richelieu.
