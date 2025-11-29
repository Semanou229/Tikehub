# Intégration Moneroo SDK Laravel

## Installation

Pour installer le SDK Moneroo Laravel, exécutez :

```bash
composer require moneroo/moneroo-laravel
php artisan moneroo:install
```

## Configuration

Ajoutez vos clés Moneroo dans le fichier `.env` :

```env
MONEROO_PUBLIC_KEY=your-public-key
MONEROO_SECRET_KEY=your-secret-key
MONEROO_WEBHOOK_SECRET=your-webhook-secret
MONEROO_MODE=sandbox  # ou 'production'
```

## Utilisation

Le service `MonerooService` a été mis à jour pour utiliser le SDK officiel Moneroo.

### Création d'un paiement

Le service gère automatiquement :
- La conversion des données au format Moneroo
- L'extraction du prénom/nom depuis le nom complet
- La gestion de l'URL de checkout pour redirection
- Le stockage de l'ID de transaction

### Vérification d'un paiement

Utilisez `verifyPayment()` pour vérifier le statut d'un paiement après le retour de l'utilisateur.

### Webhooks

Les webhooks Moneroo sont gérés via la route `/payments/callback` qui :
- Vérifie la signature du webhook
- Met à jour le statut du paiement
- Génère les QR codes et tokens d'accès virtuel si le paiement est complété

## Documentation

Pour plus d'informations, consultez : https://docs.moneroo.io/sdks/laravel

