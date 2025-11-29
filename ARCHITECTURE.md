# Architecture de Tikehub

## Vue d'ensemble

Tikehub est une plateforme marketplace d'événements développée avec Laravel 10, permettant aux organisateurs de créer, publier et gérer des événements, vendre des billets sécurisés, organiser des concours/votes payants, collecter des fonds et fournir des outils opérationnels.

## Structure du projet

### Modèles principaux

- **User** : Utilisateurs avec rôles (admin, organizer, agent, buyer)
- **Event** : Événements avec sous-domaines automatiques
- **TicketType** : Types de billets (earlybird, VIP, general)
- **Ticket** : Billets individuels avec QR codes
- **Payment** : Transactions de paiement via Moneroo
- **Contest** : Concours avec votes payants
- **ContestCandidate** : Candidats aux concours
- **Vote** : Votes avec points et paiements
- **Fundraising** : Collectes de fonds
- **Donation** : Dons individuels
- **TicketScan** : Historique des scans de billets

### Services

- **QrCodeService** : Génération et validation de QR codes sécurisés
- **MonerooService** : Intégration avec l'API Moneroo
- **PaymentService** : Gestion des paiements et remboursements
- **VoteService** : Gestion des votes avec anti-fraude

### Rôles et permissions

- **Admin** : Accès complet à la plateforme
- **Organizer** : Création et gestion d'événements
- **Agent** : Scans et ventes manuelles
- **Buyer** : Achat de billets et participation

### Fonctionnalités principales

#### 1. Marketplace d'événements
- Listing avec filtres (date, localisation, catégorie)
- Pages dédiées par événement
- Sous-domaines automatiques (ev-{slug}.tikehub.com)

#### 2. Billetterie
- Types de billets avec quotas et dates
- QR codes à usage unique (HMAC signés)
- Billets physiques et numérotation manuelle
- Scannage en temps réel via API

#### 3. Paiements
- Intégration Moneroo
- Gestion des commissions plateforme
- Remboursements partiels et totaux
- Webhooks pour notifications

#### 4. Concours/Votes
- Création de concours avec candidats
- Votes payants avec points
- Classement en temps réel
- Anti-fraude (limites par utilisateur/IP)

#### 5. Collecte de fonds
- Objectifs et paliers
- Dons anonymes ou publics
- Suivi des montants collectés

#### 6. Gestion agents
- Agents assignés aux événements
- Ventes manuelles hors-ligne
- Scans et validations

## Sécurité

- QR codes signés HMAC avec TTL
- Validation côté serveur
- Limitation des votes (par utilisateur/IP)
- KYC pour organisateurs
- HTTPS obligatoire en production
- Stockage chiffré des données sensibles

## Multi-langue

- Support français par défaut
- Middleware SetLocale pour détection automatique
- Fichiers de traduction dans `lang/fr/`

## Responsive

- Design mobile-first avec Tailwind CSS
- Interface adaptative pour tous les écrans

## Prochaines étapes

1. **Interface d'administration complète**
   - Gestion des utilisateurs et KYC
   - Tableaux de bord analytics
   - Gestion des paiements et remboursements

2. **Fonctionnalités avancées**
   - Application mobile pour scans
   - Notifications push
   - Export Excel/CSV avancé
   - Système de rapports détaillés

3. **Optimisations**
   - Cache Redis pour performances
   - Jobs en file d'attente
   - Optimisation des requêtes DB
   - CDN pour les assets

4. **Tests**
   - Tests unitaires
   - Tests d'intégration
   - Tests E2E


