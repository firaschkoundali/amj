# Guide de Déploiement Gratuit - Application Symfony AMJ

Ce guide vous présente les meilleures options gratuites pour déployer votre application Symfony.

## 🎯 Options Recommandées (Gratuites)

### 1. **Render.com** ⭐ (Recommandé)
- **Gratuit** : 750 heures/mois
- Support PHP/Symfony natif
- Base de données PostgreSQL gratuite
- Déploiement automatique depuis GitHub

### 2. **Railway.app**
- **Gratuit** : $5 de crédit/mois
- Support PHP/Symfony
- Base de données incluse
- Déploiement automatique

### 3. **Fly.io**
- **Gratuit** : 3 VMs partagées
- Excellent pour Symfony
- Base de données PostgreSQL gratuite

### 4. **InfinityFree / 000webhost**
- **100% Gratuit** (avec publicité)
- Hébergement PHP classique
- Base de données MySQL gratuite
- Limites de ressources

---

## 📋 Option 1 : Déploiement sur Render.com (Recommandé)

### Étape 1 : Préparer l'application

1. **Créer un fichier `.env.production`** :
```bash
APP_ENV=prod
APP_SECRET=votre_secret_aleatoire_32_caracteres
DATABASE_URL="postgresql://user:password@host:5432/dbname"
```

2. **Créer un fichier `render.yaml`** à la racine :
```yaml
services:
  - type: web
    name: symfony-amj
    env: php
    buildCommand: composer install --no-dev --optimize-autoloader
    startCommand: php -S 0.0.0.0:$PORT -t public
    envVars:
      - key: APP_ENV
        value: prod
      - key: APP_SECRET
        generateValue: true
      - key: DATABASE_URL
        fromDatabase:
          name: symfony-db
          property: connectionString
    healthCheckPath: /

databases:
  - name: symfony-db
    plan: free
    databaseName: symfony
    user: symfony
```

3. **Créer un fichier `Procfile`** (pour Heroku/Render) :
```
web: php -S 0.0.0.0:$PORT -t public
```

### Étape 2 : Préparer le code

1. **Optimiser pour la production** :
```bash
# Dans votre projet
composer install --no-dev --optimize-autoloader
php bin/console cache:clear --env=prod
php bin/console cache:warmup --env=prod
```

2. **Créer un fichier `.gitignore`** si absent :
```
/.env
/.env.local
/.env.*.local
/vendor/
/var/
/node_modules/
```

### Étape 3 : Déployer sur Render

1. **Créer un compte** sur [render.com](https://render.com)
2. **Connecter votre repository GitHub**
3. **Créer un nouveau Web Service**
4. **Configurer** :
   - **Build Command** : `composer install --no-dev --optimize-autoloader`
   - **Start Command** : `php -S 0.0.0.0:$PORT -t public`
   - **Environment** : `PHP`
5. **Ajouter les variables d'environnement** :
   - `APP_ENV=prod`
   - `APP_SECRET` (généré automatiquement ou créez-en un)
   - `DATABASE_URL` (sera fourni après création de la DB)
6. **Créer une base de données PostgreSQL** (gratuite)
7. **Déployer** !

---

## 📋 Option 2 : Déploiement sur Railway.app

### Étape 1 : Préparer l'application

1. **Créer un fichier `railway.json`** :
```json
{
  "$schema": "https://railway.app/railway.schema.json",
  "build": {
    "builder": "NIXPACKS"
  },
  "deploy": {
    "startCommand": "php -S 0.0.0.0:$PORT -t public",
    "restartPolicyType": "ON_FAILURE",
    "restartPolicyMaxRetries": 10
  }
}
```

2. **Créer un fichier `nixpacks.toml`** :
```toml
[phases.setup]
nixPkgs = ["php82", "composer"]

[phases.install]
cmds = ["composer install --no-dev --optimize-autoloader"]

[start]
cmd = "php -S 0.0.0.0:$PORT -t public"
```

### Étape 2 : Déployer

1. **Créer un compte** sur [railway.app](https://railway.app)
2. **Nouveau projet** → **Deploy from GitHub repo**
3. **Ajouter une base de données PostgreSQL**
4. **Configurer les variables d'environnement**
5. **Déployer** !

---

## 📋 Option 3 : Déploiement sur InfinityFree (100% Gratuit)

### Étape 1 : Préparer l'application

1. **Optimiser pour la production** :
```bash
composer install --no-dev --optimize-autoloader
php bin/console cache:clear --env=prod
```

2. **Créer un fichier `.htaccess`** dans `public/` :
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
```

### Étape 2 : Déployer

1. **Créer un compte** sur [infinityfree.net](https://www.infinityfree.net)
2. **Créer un site** (hébergement gratuit)
3. **Uploader les fichiers** via FTP ou File Manager
4. **Configurer la base de données MySQL** (gratuite)
5. **Mettre à jour `.env`** avec les informations de la DB
6. **Configurer le domaine** (sous-domaine gratuit fourni)

---

## 🔧 Configuration Requise pour Tous les Déploiements

### 1. Variables d'environnement à configurer

```env
APP_ENV=prod
APP_SECRET=votre_secret_32_caracteres
DATABASE_URL="mysql://user:password@host:3306/dbname"
# ou pour PostgreSQL:
DATABASE_URL="postgresql://user:password@host:5432/dbname"
```

### 2. Générer APP_SECRET

```bash
php bin/console secrets:generate-keys
php bin/console secrets:set APP_SECRET
```

### 3. Migrations de base de données

Après le déploiement, exécutez :
```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

### 4. Créer l'utilisateur admin

```bash
php bin/console app:create-admin-user
```

---

## 📝 Checklist de Déploiement

- [ ] Code optimisé pour la production (`composer install --no-dev`)
- [ ] Variables d'environnement configurées
- [ ] Base de données créée et configurée
- [ ] Migrations exécutées
- [ ] Cache Symfony vidé et réchauffé
- [ ] Permissions des dossiers `var/` et `public/` correctes
- [ ] Fichier `.htaccess` configuré (si Apache)
- [ ] Tests effectués en production

---

## 🚀 Commandes Utiles Après Déploiement

```bash
# Vider le cache
php bin/console cache:clear --env=prod

# Réchauffer le cache
php bin/console cache:warmup --env=prod

# Exécuter les migrations
php bin/console doctrine:migrations:migrate --no-interaction

# Créer l'utilisateur admin
php bin/console app:create-admin-user
```

---

## ⚠️ Notes Importantes

1. **Ne jamais commiter** `.env` ou `.env.local`
2. **Utiliser** `APP_ENV=prod` en production
3. **Optimiser** les assets (CSS/JS minifiés)
4. **Activer** le cache Symfony en production
5. **Configurer** les permissions : `var/` et `public/` doivent être accessibles en écriture

---

## 🆘 Support

En cas de problème :
1. Vérifier les logs : `var/log/prod.log`
2. Vérifier les variables d'environnement
3. Vérifier la connexion à la base de données
4. Vérifier les permissions des fichiers

---

## 📚 Ressources

- [Documentation Symfony - Déploiement](https://symfony.com/doc/current/deployment.html)
- [Render.com Documentation](https://render.com/docs)
- [Railway.app Documentation](https://docs.railway.app)

