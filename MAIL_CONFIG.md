# Configuration Email SMTP

## Variables d'environnement à ajouter dans votre fichier .env

Ajoutez les lignes suivantes dans votre fichier `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=mail.digitartisan.net
MAIL_PORT=465
MAIL_USERNAME=hello@digitartisan.net
MAIL_PASSWORD=Jesuislebossdugame@229
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=hello@digitartisan.net
MAIL_FROM_NAME="Tikehub"
```

## Après avoir mis à jour le .env

Exécutez la commande suivante pour vider le cache de configuration :

```bash
php artisan config:clear
```

## Système d'emails implémenté

### 1. Vérification d'email à l'inscription
- Email de vérification envoyé automatiquement lors de la création du compte
- Email de bienvenue envoyé après l'inscription
- Lien de vérification valide 60 minutes
- Page de vérification d'email accessible via `/email/verify`

### 2. Notifications automatiques

#### Commandes et Paiements
- **OrderConfirmationNotification** : Envoyé quand un paiement est confirmé
- **OrderStatusChangedNotification** : Envoyé lors des changements de statut de commande

#### Billets
- **TicketReadyNotification** : Envoyé quand un billet est prêt (QR code généré)

#### Vérification KYC
- **KycStatusChangedNotification** : Envoyé lors des changements de statut KYC (pending, verified, rejected)

#### Retraits
- **WithdrawalStatusChangedNotification** : Envoyé lors des changements de statut de retrait

### 3. Routes de vérification

- `GET /email/verify` - Page de vérification d'email (nécessite authentification)
- `GET /email/verify/{id}/{hash}` - Lien de vérification (signé)
- `POST /email/verification-notification` - Renvoyer l'email de vérification

### 4. Middleware

Le middleware `verified` est disponible pour protéger les routes nécessitant une vérification d'email.

