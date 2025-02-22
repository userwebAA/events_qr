# Guide de Déploiement - Application QR Events

Ce guide détaille les étapes nécessaires pour déployer l'application QR Events en production.

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et NPM
- PostgreSQL 14 ou supérieur
- Serveur web (Apache/Nginx)
- SSL/TLS pour HTTPS

## Étapes de Déploiement

### 1. Préparation du Serveur

```bash
# Installation des dépendances système (Ubuntu/Debian)
 - php >=8.1-pgsql 
 - mbstring 
 - xml 
 - curl 
 - zip
 - postgresql
 - postgresql-contrib
 - nginx ou apache2
```

### 2. Configuration du Projet

1. Cloner le repository :
```bash
git clone [https://github.com/userwebAA/events_qr.git]
cd events_qr
```

2. Installer les dépendances :
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

3. Configuration de l'environnement :
```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer le fichier `.env` :
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://quiz.eventsfive.com

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=qrcode_quiz
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

5. Optimiser Laravel :
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Base de Données


1. Importer la base de données existante :
```bash
# Se placer à la racine du projet où se trouve le fichier SQL
sudo -u postgres psql qrcode_quiz < pg_dump.sql 
ou 
sudo -u postgres psql qrcode_quiz < mysql_dump.sql 

```

### 4. Configuration du Serveur Web (Nginx)

Créer une configuration Nginx :

```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /chemin/vers/events_qr/public;

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

### 5. SSL/TLS (Let's Encrypt)

```bash
apt install certbot python3-certbot-nginx
certbot --nginx -d votre-domaine.com
```

### 6. Permissions

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### 7. Maintenance et Surveillance

- Configurer la surveillance des logs :
```bash
tail -f storage/logs/laravel.log
```

- Pour les mises à jour futures :
```bash
php artisan down
git pull
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan up
```

## Sécurité

- Assurez-vous que tous les mots de passe sont sécurisés
- Configurez les sauvegardes automatiques de la base de données PostgreSQL :
```bash
# Créer un script de backup
pg_dump -U votre_utilisateur qrcode_quiz > backup_$(date +%Y%m%d).sql
```
- Maintenez le système à jour

## Support

En cas de problème lors du déploiement, consultez les logs dans `storage/logs/laravel.log`.
