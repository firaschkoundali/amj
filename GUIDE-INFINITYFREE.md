# 🚀 Guide Complet : Déploiement sur InfinityFree (MySQL Gratuit)

Ce guide vous accompagne étape par étape pour déployer votre application Symfony sur InfinityFree avec MySQL.

---

## 📋 Prérequis

- ✅ Compte GitHub avec votre code
- ✅ Application Symfony fonctionnelle en local
- ✅ Compte InfinityFree (gratuit)

---

## Étape 1 : Créer un compte InfinityFree

1. Allez sur [infinityfree.net](https://www.infinityfree.net)
2. Cliquez sur **"Sign Up"** (Inscription)
3. Remplissez le formulaire :
   - Email
   - Mot de passe
   - Nom d'utilisateur
4. Confirmez votre email
5. Connectez-vous

---

## Étape 2 : Créer un site

1. Dans le **Control Panel**, cliquez sur **"Create Account"**
2. Remplissez :
   - **Domain** : Choisissez un sous-domaine (ex: `amj-djerba`)
   - **Site Name** : Nom de votre site
   - **PHP Version** : Sélectionnez **PHP 8.2** ou la plus récente
3. Cliquez sur **"Create Account"**
4. Attendez quelques minutes que le site soit créé

---

## Étape 3 : Créer la base de données MySQL

1. Dans le **Control Panel**, allez dans **"MySQL Databases"**
2. Cliquez sur **"Create Database"**
3. Remplissez :
   - **Database Name** : `amj_db` (ou autre nom)
   - **Password** : Créez un mot de passe fort
4. Cliquez sur **"Create Database"**
5. **IMPORTANT** : Notez ces informations :
   - **Server** : `sqlXXX.infinityfree.com` (ou `localhost`)
   - **Database Name** : `epiz_XXXXXX_amj_db`
   - **Username** : `epiz_XXXXXX`
   - **Password** : (celui que vous avez créé)
   - **Port** : `3306`

---

## Étape 4 : Préparer l'application en local

### 4.1 Optimiser pour la production

```bash
# Dans votre projet local
cd symfony-amj

# Installer les dépendances sans dev
composer install --no-dev --optimize-autoloader

# Vider le cache
php bin/console cache:clear --env=prod
```

### 4.2 Créer le fichier `.htaccess`

Créez ou vérifiez que `public/.htaccess` existe :

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Rediriger toutes les requêtes vers index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>

# Sécurité : Empêcher l'accès aux fichiers sensibles
<FilesMatch "^\.">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### 4.3 Créer un fichier `.env.production`

Créez un fichier `.env.production` avec le template (ne le commitez pas) :

```env
APP_ENV=prod
APP_SECRET=GENERATE_A_32_CHARACTER_SECRET_HERE
DATABASE_URL="mysql://epiz_XXXXXX:password@sqlXXX.infinityfree.com:3306/epiz_XXXXXX_amj_db?serverVersion=8.0.32&charset=utf8mb4"
```

**Générer APP_SECRET** :
```bash
php -r "echo bin2hex(random_bytes(16));"
```

---

## Étape 5 : Uploader les fichiers

### Option A : Via FTP (Recommandé)

1. **Installer FileZilla** (gratuit) : [filezilla-project.org](https://filezilla-project.org)

2. **Récupérer les identifiants FTP** :
   - Dans le Control Panel, allez dans **"FTP Accounts"**
   - Notez :
     - **Host** : `ftpupload.net` (ou celui indiqué)
     - **Username** : `epiz_XXXXXX`
     - **Password** : (votre mot de passe FTP)

3. **Connecter FileZilla** :
   - Hôte : `ftpupload.net`
   - Nom d'utilisateur : `epiz_XXXXXX`
   - Mot de passe : (votre mot de passe)
   - Port : `21`

4. **Uploader les fichiers** :
   - Naviguez vers `htdocs/` ou `public_html/`
   - **IMPORTANT** : Uploader TOUS les fichiers du projet Symfony
   - Structure attendue :
     ```
     htdocs/
     ├── bin/
     ├── config/
     ├── public/
     │   ├── index.php
     │   └── .htaccess
     ├── src/
     ├── templates/
     ├── vendor/
     ├── .env
     └── composer.json
     ```

### Option B : Via File Manager

1. Dans le Control Panel, allez dans **"File Manager"**
2. Naviguez vers `htdocs/` ou `public_html/`
3. Cliquez sur **"Upload"**
4. Sélectionnez tous les fichiers de votre projet
5. Attendez la fin de l'upload

---

## Étape 6 : Configurer le point d'entrée

### 6.1 Vérifier la structure

Sur InfinityFree, le point d'entrée doit être dans `htdocs/` ou `public_html/`.

**Option A : Structure standard (Recommandé)**
```
htdocs/
├── bin/
├── config/
├── public/
│   ├── index.php
│   └── .htaccess
├── src/
└── ...
```

Créez un fichier `.htaccess` à la racine de `htdocs/` :
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ public/index.php [QSA,L]
</IfModule>
```

**Option B : Déplacer public/ à la racine**
Si InfinityFree ne permet pas de modifier le point d'entrée, vous pouvez :
1. Copier le contenu de `public/` vers `htdocs/`
2. Ajuster les chemins dans `index.php`

---

## Étape 7 : Configurer `.env` sur le serveur

1. **Via File Manager ou FTP**, créez/modifiez le fichier `.env` dans `htdocs/`
2. Ajoutez :
```env
APP_ENV=prod
APP_SECRET=votre_secret_32_caracteres
DATABASE_URL="mysql://epiz_XXXXXX:password@sqlXXX.infinityfree.com:3306/epiz_XXXXXX_amj_db?serverVersion=8.0.32&charset=utf8mb4"
```

**Remplacez** :
- `epiz_XXXXXX` par votre username
- `password` par votre mot de passe MySQL
- `sqlXXX.infinityfree.com` par votre serveur MySQL
- `epiz_XXXXXX_amj_db` par votre nom de base de données

---

## Étape 8 : Exécuter les migrations

### Option A : Via Terminal (si disponible)

1. Dans le Control Panel, allez dans **"Advanced"** → **"Terminal"**
2. Connectez-vous via SSH
3. Naviguez vers votre projet :
```bash
cd ~/htdocs
```
4. Exécutez les migrations :
```bash
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console app:create-admin
```

### Option B : Via Script PHP temporaire

Si le Terminal n'est pas disponible, créez un fichier `setup.php` dans `htdocs/` :

```php
<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$kernel = new App\Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
$kernel->boot();

$application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
$application->setAutoExit(false);

// Exécuter les migrations
$application->run(new \Symfony\Component\Console\Input\ArrayInput([
    'command' => 'doctrine:migrations:migrate',
    '--no-interaction' => true,
]));

// Créer l'admin
$application->run(new \Symfony\Component\Console\Input\ArrayInput([
    'command' => 'app:create-admin',
]));

echo "Setup terminé !";
```

Accédez à `https://votre-site.infinityfreeapp.com/setup.php` une fois, puis **supprimez ce fichier** pour la sécurité.

---

## Étape 9 : Configurer les permissions

Via **File Manager** ou **FTP**, donnez les permissions suivantes :
- `var/` : `775` (lecture/écriture)
- `var/cache/` : `775`
- `var/log/` : `775`
- `public/` : `755`

---

## Étape 10 : Tester le site

1. Allez sur votre site : `https://votre-site.infinityfreeapp.com`
2. Testez :
   - Page d'accueil
   - Page d'inscription
   - Connexion admin

---

## 🔧 Dépannage

### Erreur : "Database connection failed"
- ✅ Vérifiez que `DATABASE_URL` est correct
- ✅ Vérifiez que la base de données existe
- ✅ Vérifiez les identifiants MySQL

### Erreur : "500 Internal Server Error"
- ✅ Vérifiez les logs dans `var/log/prod.log`
- ✅ Vérifiez les permissions de `var/`
- ✅ Vérifiez que `.env` est bien configuré

### Erreur : "Class not found"
- ✅ Vérifiez que `vendor/` est bien uploadé
- ✅ Exécutez `composer install` sur le serveur (si Terminal disponible)

### Erreur : "Route not found"
- ✅ Vérifiez que `.htaccess` est bien configuré
- ✅ Vérifiez que `public/index.php` est accessible

---

## 📝 Checklist Finale

- [ ] Compte InfinityFree créé
- [ ] Site créé
- [ ] Base de données MySQL créée
- [ ] Fichiers uploadés via FTP
- [ ] `.env` configuré avec les bonnes informations
- [ ] `.htaccess` créé et configuré
- [ ] Migrations exécutées
- [ ] Utilisateur admin créé
- [ ] Permissions configurées
- [ ] Site testé et fonctionnel

---

## 🎉 Félicitations !

Votre application Symfony est maintenant déployée sur InfinityFree avec MySQL, sans problème de compatibilité !

---

## 💡 Astuces

1. **Domaine personnalisé** : Vous pouvez ajouter votre propre domaine (gratuit) pour enlever la publicité
2. **Backup** : Faites régulièrement des backups de votre base de données via cPanel
3. **Performance** : Activez le cache Symfony en production pour de meilleures performances

