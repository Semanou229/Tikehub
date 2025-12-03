# Configuration PWA - Tikehub

L'application Tikehub a été transformée en Progressive Web App (PWA) complète.

## Fonctionnalités PWA implémentées

### ✅ Service Worker
- Mise en cache des ressources statiques
- Mode hors ligne avec page dédiée
- Stratégies de cache optimisées (Network First pour HTML, Cache First pour assets)
- Support des notifications push (prêt pour implémentation)
- Background sync (prêt pour implémentation)
- Mise à jour automatique du service worker

### ✅ Manifest.json
- Configuration complète pour installation
- Icônes multiples tailles (72x72 à 512x512)
- Raccourcis d'application
- Thème et couleurs personnalisées
- Support multi-langue

### ✅ Installation
- Bouton d'installation visible dans l'interface
- Détection automatique de l'éligibilité à l'installation
- Masquage automatique si déjà installée

### ✅ Mode hors ligne
- Page offline dédiée (`/offline`)
- Gestion des erreurs réseau
- Cache intelligent des pages visitées

## Génération des icônes PWA

### Méthode 1 : Node.js (Recommandé)

```bash
# Installer les dépendances
npm install

# Générer les icônes
npm run generate-icons
```

### Méthode 2 : Outils en ligne

Si Node.js n'est pas disponible, utilisez un outil en ligne :
1. Allez sur https://realfavicongenerator.net/ ou https://www.pwabuilder.com/imageGenerator
2. Uploadez le fichier `public/icons/icon.svg`
3. Téléchargez les icônes générées
4. Placez-les dans le dossier `public/icons/`

### Tailles requises

Les icônes suivantes doivent être présentes dans `public/icons/` :
- icon-72x72.png
- icon-96x96.png
- icon-128x128.png
- icon-144x144.png
- icon-152x152.png
- icon-192x192.png
- icon-384x384.png
- icon-512x512.png

## Test de la PWA

### 1. Vérifier le Service Worker
1. Ouvrez les outils de développement (F12)
2. Allez dans l'onglet "Application" (Chrome) ou "Stockage" (Firefox)
3. Vérifiez que le Service Worker est enregistré et actif

### 2. Tester le mode hors ligne
1. Ouvrez les outils de développement
2. Allez dans l'onglet "Network"
3. Activez "Offline"
4. Rechargez la page
5. La page offline devrait s'afficher

### 3. Tester l'installation
1. Sur Chrome/Edge : Le bouton d'installation apparaîtra automatiquement
2. Sur Firefox : Menu > Installer
3. Sur Safari iOS : Partage > Sur l'écran d'accueil

## Configuration HTTPS

⚠️ **Important** : Les PWA nécessitent HTTPS en production (sauf localhost).

Pour le développement local :
- `http://localhost` fonctionne
- `http://127.0.0.1` fonctionne

Pour la production :
- Configurez un certificat SSL
- Utilisez HTTPS pour toutes les requêtes

## Améliorations futures possibles

1. **Notifications push** : Implémenter les notifications pour les événements, paiements, etc.
2. **Background sync** : Synchroniser les données en arrière-plan
3. **Share Target API** : Permettre le partage de contenu vers l'app
4. **File System Access API** : Gestion avancée des fichiers
5. **Periodic Background Sync** : Synchronisation périodique

## Support navigateur

- ✅ Chrome/Edge (Android, Desktop)
- ✅ Firefox (Android, Desktop)
- ✅ Safari (iOS 11.3+, macOS)
- ⚠️ Safari (iOS) : Support limité
- ❌ Internet Explorer : Non supporté

## Dépannage

### Le Service Worker ne s'enregistre pas
- Vérifiez que vous êtes sur HTTPS ou localhost
- Vérifiez la console pour les erreurs
- Assurez-vous que `public/sw.js` est accessible

### Les icônes ne s'affichent pas
- Vérifiez que les fichiers PNG existent dans `public/icons/`
- Vérifiez les chemins dans `manifest.json`
- Videz le cache du navigateur

### Le bouton d'installation n'apparaît pas
- Vérifiez que toutes les conditions PWA sont remplies
- L'app doit être servie en HTTPS (sauf localhost)
- Le manifest.json doit être valide
- Au moins une icône 192x192 et 512x512 doit être présente

## Ressources

- [MDN - Progressive Web Apps](https://developer.mozilla.org/fr/docs/Web/Progressive_web_apps)
- [Web.dev - PWA](https://web.dev/progressive-web-apps/)
- [PWA Builder](https://www.pwabuilder.com/)

