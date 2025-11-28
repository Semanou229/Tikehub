# Tikehub - Plateforme Marketplace d'Événements

Plateforme web complète permettant aux organisateurs de créer, publier et gérer des événements, vendre des billets sécurisés, organiser des concours/votes payants, collecter des fonds et fournir des outils opérationnels.

## Fonctionnalités principales

- 🎫 **Billetterie sécurisée** avec QR codes à usage unique
- 🎯 **Marketplace d'événements** avec sous-domaines automatiques
- 💰 **Paiements** via Moneroo
- 🏆 **Concours/Votes payants** en temps réel
- 💝 **Collecte de fonds** pour événements caritatifs
- 👥 **Gestion agents** et billetterie manuelle
- 📊 **Rapports et analytics** complets
- 🌍 **Multi-langue** (départ francophone)
- 📱 **Responsive mobile-first**

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Structure des rôles

- **Acheteur** : Recherche et achète des billets, participe aux concours
- **Organisateur (Creator)** : Crée et gère des événements
- **Agent/Vendeur** : Gère les ventes manuelles et scans
- **Admin plateforme** : Modération et gestion globale
- **Admin événement** : Droits délégués par organisateur

## Technologies

- Laravel 10
- MySQL
- QR Code (SimpleSoftwareIO)
- PDF (DomPDF)
- Spatie Permissions
- Intervention Image

## Licence

MIT

