# 🚀 Guide Rapide - Déploiement InfinityFree

## ✅ Fichiers créés automatiquement

- ✅ `.htaccess` (à la racine)
- ✅ `setup.php` (pour exécuter les migrations)
- ✅ `prepare-deployment.bat` (script de préparation)

## 📋 Étapes à suivre

### 1. Préparer l'application

Double-cliquez sur `prepare-deployment.bat` ou exécutez :

```bash
composer install --no-dev --optimize-autoloader
php bin/console cache:clear --env=prod
```

**APP_SECRET généré** : `8a176db31e171e58bb3e978eaf8a6b28`

### 2. Créer le fichier `.env`

Créez un fichier `.env` à la racine avec :

```env
APP_ENV=prod
APP_SECRET=8a176db31e171e58bb3e978eaf8a6b28
DATABASE_URL="mysql://USERNAME:PASSWORD@HOST:3306/DATABASE_NAME?serverVersion=8.0.32&charset=utf8mb4"
```

**Remplacez** :
- `USERNAME` → votre username MySQL (ex: `epiz_12345678_amj_user`)
- `PASSWORD` → votre mot de passe MySQL
- `HOST` → votre host MySQL (ex: `sql123.epizy.com`)
- `DATABASE_NAME` → votre nom de base (ex: `epiz_12345678_amj_db`)

### 3. Uploader les fichiers via FTP

1. Installez **FileZilla** : https://filezilla-project.org
2. Connectez-vous avec vos identifiants FTP InfinityFree
3. Naviguez vers `htdocs/` sur le serveur
4. **Uploader TOUS les fichiers** :
   - `bin/`, `config/`, `public/`, `src/`, `templates/`, `vendor/`, `var/`
   - `.htaccess`, `.env`, `setup.php`, `composer.json`, etc.

### 4. Configurer les permissions

Via File Manager ou FTP :
- `var/` → **775**
- `var/cache/` → **775**
- `var/log/` → **775**

### 5. Exécuter les migrations

Accédez à : `https://votre-site.infinityfreeapp.com/setup.php`

Le script va :
- ✅ Exécuter les migrations
- ✅ Créer l'utilisateur admin
- ✅ Vérifier la base de données

### 6. Supprimer setup.php

**IMPORTANT** : Supprimez `setup.php` après utilisation (sécurité)

### 7. Tester le site

- Page d'accueil : `https://votre-site.infinityfreeapp.com`
- Inscription : `https://votre-site.infinityfreeapp.com/inscription`
- Admin : `https://votre-site.infinityfreeapp.com/login`

## 🔧 Dépannage

### Erreur "Database connection failed"
- Vérifiez `.env` (syntaxe correcte)
- Vérifiez les identifiants MySQL dans cPanel

### Erreur "500 Internal Server Error"
- Vérifiez les permissions de `var/` (doit être 775)
- Vérifiez les logs : `var/log/prod.log`

### Erreur "Route not found"
- Vérifiez que `.htaccess` existe à la racine
- Vérifiez que `public/index.php` existe

## 📞 Besoin d'aide ?

Consultez `DOCUMENTATION-INFINITYFREE.md` pour le guide complet.

