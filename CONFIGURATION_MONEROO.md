# Configuration Moneroo pour Tikehub

## Clés API

Les clés Moneroo ont été configurées dans le fichier `.env` :

```env
MONEROO_SECRET_KEY=pvk_n0qub9|01KATGZW4TFTH03M446AKM6YEE
MONEROO_PUBLIC_KEY=votre-public-key
MONEROO_WEBHOOK_SECRET=votre-webhook-secret
MONEROO_MODE=sandbox
```

**Note importante** : Vous devez également obtenir votre `PUBLIC_KEY` depuis votre dashboard Moneroo et l'ajouter dans le fichier `.env`.

## Webhook

L'URL du webhook configurée est : `https://comptemarket.net/webhook`

### Routes disponibles

1. **Route principale** : `https://comptemarket.net/payments/callback`
   - Méthode : POST
   - Contrôleur : `PaymentController@callback`
   - Middleware : Aucun (accessible publiquement)

2. **Route alternative** : `https://comptemarket.net/api/moneroo/webhook`
   - Méthode : POST
   - Contrôleur : `PaymentController@webhook`
   - Middleware : Aucun (accessible publiquement)

### Configuration dans Moneroo Dashboard

Vous devez configurer le webhook dans votre dashboard Moneroo pour pointer vers :
- **URL recommandée** : `https://comptemarket.net/payments/callback`
- **Méthode** : POST
- **Header de signature** : `X-Moneroo-Signature`

### Vérification de la signature

Le webhook vérifie automatiquement la signature envoyée par Moneroo dans le header `X-Moneroo-Signature` en utilisant le `MONEROO_WEBHOOK_SECRET`.

## Test

Pour tester le webhook :
1. Créez un paiement de test depuis votre application
2. Vérifiez que le webhook est bien reçu dans les logs Laravel
3. Vérifiez que le statut du paiement est mis à jour correctement

## Logs

Les erreurs de webhook sont enregistrées dans `storage/logs/laravel.log`.

