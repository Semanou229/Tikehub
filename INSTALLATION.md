# Guide d'installation - Tikehub

## Prérequis

- PHP >= 8.1
- Composer
- MySQL >= 5.7 ou MariaDB >= 10.3
- Node.js et NPM (pour les assets frontend si nécessaire)

## Installation

1. **Cloner le projet et installer les dépendances**

```bash
composer install
```

2. **Configurer l'environnement**

```bash
cp .env.example .env
php artisan key:generate
```

3. **Configurer la base de données**

Éditez le fichier `.env` et configurez :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tikehub
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

4. **Exécuter les migrations**

```bash
php artisan migrate --seed
```

5. **Créer le lien symbolique pour le stockage**

```bash
php artisan storage:link
```

6. **Configurer Moneroo**

Ajoutez vos clés API dans le fichier `.env` :
```env
MONEROO_API_KEY=votre_clé_api
MONEROO_API_SECRET=votre_secret
MONEROO_WEBHOOK_SECRET=votre_secret_webhook
MONEROO_MODE=sandbox
```

7. **Démarrer le serveur**

```bash
php artisan serve
```

L'application sera accessible sur `http://localhost:8000`

## Comptes par défaut

Après l'installation, vous pouvez vous connecter avec :

- **Admin**: admin@tikehub.com / password
- **Organisateur**: organizer@tikehub.com / password

## Configuration des sous-domaines

Pour activer les sous-domaines automatiques, configurez votre serveur web (Apache/Nginx) pour pointer tous les sous-domaines `*.tikehub.com` vers le répertoire public de Laravel.

### Exemple Nginx

```nginx
server {
    listen 80;
    server_name *.tikehub.com tikehub.com;
    root /chemin/vers/tikehub/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Permissions

Assurez-vous que les répertoires suivants sont accessibles en écriture :

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Prochaines étapes

1. Configurez votre serveur de messagerie pour les emails transactionnels
2. Configurez le service SMS (optionnel)
3. Configurez le stockage de fichiers (local ou S3)
4. Activez HTTPS en production
5. Configurez les jobs en file d'attente pour les tâches asynchrones


