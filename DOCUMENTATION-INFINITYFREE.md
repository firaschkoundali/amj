# 📚 Documentation Complète : Déploiement Symfony sur InfinityFree

Guide complet et détaillé pour déployer votre application Symfony sur InfinityFree avec MySQL.

---

## 📑 Table des Matières

1. [Introduction à InfinityFree](#introduction)
2. [Création du Compte](#creation-compte)
3. [Configuration du Site](#configuration-site)
4. [Configuration de la Base de Données MySQL](#configuration-mysql)
5. [Préparation de l'Application](#preparation-app)
6. [Upload des Fichiers](#upload-fichiers)
7. [Configuration de l'Environnement](#configuration-env)
8. [Exécution des Migrations](#execution-migrations)
9. [Configuration des Permissions](#permissions)
10. [Test et Vérification](#test-verification)
11. [Dépannage](#depannage)
12. [Optimisations](#optimisations)
13. [FAQ](#faq)

---

## 🎯 Introduction {#introduction}

### Qu'est-ce qu'InfinityFree ?

InfinityFree est un service d'hébergement web **100% gratuit** qui offre :
- ✅ Hébergement PHP illimité
- ✅ Base de données MySQL gratuite
- ✅ Sous-domaine gratuit (ex: `votre-site.infinityfreeapp.com`)
- ✅ cPanel complet
- ✅ FTP et File Manager
- ✅ Support PHP 8.2

### Avantages pour Symfony

- ✅ **MySQL gratuit** : Compatible avec votre base de données locale
- ✅ **Pas de problème de migrations** : Même SGBD en local et production
- ✅ **Facile à configurer** : Interface intuitive
- ✅ **Gratuit sans limite de temps**

### Limitations

- ⚠️ **Publicité** : Bandeau publicitaire en bas de page (peut être désactivé avec domaine personnalisé)
- ⚠️ **Ressources limitées** : CPU et RAM limités (suffisant pour un site moyen)
- ⚠️ **Pas de déploiement automatique** : Upload manuel via FTP

---

## 📝 Étape 1 : Création du Compte {#creation-compte}

### 1.1 Inscription

1. Allez sur [infinityfree.net](https://www.infinityfree.net)
2. Cliquez sur **"Sign Up"** (en haut à droite)
3. Remplissez le formulaire :
   ```
   Email : votre@email.com
   Username : votre_nom_utilisateur
   Password : votre_mot_de_passe_fort
   ```
4. Acceptez les conditions d'utilisation
5. Cliquez sur **"Create Account"**

### 1.2 Vérification Email

1. Vérifiez votre boîte email
2. Cliquez sur le lien de confirmation
3. Votre compte est maintenant activé

### 1.3 Connexion

1. Allez sur [infinityfree.net](https://www.infinityfree.net)
2. Cliquez sur **"Login"**
3. Entrez vos identifiants
4. Vous accédez au **Control Panel**

---

## 🌐 Étape 2 : Configuration du Site {#configuration-site}

### 2.1 Créer un Nouveau Site

1. Dans le **Control Panel**, cliquez sur **"Create Account"** (ou **"Add Website"**)
2. Remplissez le formulaire :

   **Domain Selection** :
   - Choisissez **"Use a Subdomain"**
   - Entrez un nom : `amj-djerba` (ou autre)
   - Votre URL sera : `amj-djerba.infinityfreeapp.com`

   **Account Details** :
   - **Site Name** : `AMJ Djerba` (ou autre)
   - **PHP Version** : Sélectionnez **PHP 8.2** (ou la plus récente)
   - **Auto SSL** : ✅ Activé (recommandé)

3. Cliquez sur **"Create Account"**
4. Attendez **2-5 minutes** que le site soit créé

### 2.2 Vérifier la Création

1. Une fois créé, vous verrez votre site dans la liste
2. Cliquez sur **"Manage"** pour accéder au panneau de contrôle
3. Notez votre **cPanel URL** (ex: `cpanel.epizy.com`)

---

## 🗄️ Étape 3 : Configuration de la Base de Données MySQL {#configuration-mysql}

### 3.1 Accéder à MySQL Databases

1. Dans le **Control Panel**, cliquez sur **"MySQL Databases"**
2. Ou allez directement dans **cPanel** → **MySQL Databases**

### 3.2 Créer une Nouvelle Base de Données

1. Dans la section **"Create New Database"** :
   - **Database Name** : `amj_db` (ou autre nom)
   - Cliquez sur **"Create Database"**

2. **IMPORTANT** : Notez le nom complet de la base :
   - Format : `epiz_XXXXXX_amj_db`
   - Exemple : `epiz_12345678_amj_db`

### 3.3 Créer un Utilisateur MySQL

1. Dans la section **"Add New User"** :
   - **Username** : `amj_user` (ou autre)
   - **Password** : Créez un mot de passe fort (minimum 12 caractères)
   - Cliquez sur **"Create User"**

2. **IMPORTANT** : Notez le nom complet de l'utilisateur :
   - Format : `epiz_XXXXXX_amj_user`
   - Exemple : `epiz_12345678_amj_user`

### 3.4 Associer l'Utilisateur à la Base

1. Dans **"Add User To Database"** :
   - Sélectionnez l'utilisateur : `epiz_XXXXXX_amj_user`
   - Sélectionnez la base : `epiz_XXXXXX_amj_db`
   - Cliquez sur **"Add"**

2. Cochez **"ALL PRIVILEGES"**
3. Cliquez sur **"Make Changes"**

### 3.5 Récupérer les Informations de Connexion

Notez ces informations (vous en aurez besoin pour `.env`) :

```
Host : sqlXXX.epizy.com (ou sqlXXX.infinityfree.com)
Port : 3306
Database : epiz_XXXXXX_amj_db
Username : epiz_XXXXXX_amj_user
Password : votre_mot_de_passe
```

**Où trouver le Host ?** :
- Dans cPanel → **"Remote MySQL"** ou **"MySQL Databases"**
- Format généralement : `sqlXXX.epizy.com` ou `sqlXXX.infinityfree.com`

---

## 💻 Étape 4 : Préparation de l'Application {#preparation-app}

### 4.1 Optimiser pour la Production

Dans votre projet local, exécutez :

```bash
# Aller dans le dossier du projet
cd symfony-amj

# Installer les dépendances sans les packages de développement
composer install --no-dev --optimize-autoloader

# Vider le cache
php bin/console cache:clear --env=prod

# Optionnel : Réchauffer le cache
php bin/console cache:warmup --env=prod
```

### 4.2 Vérifier/Créer `.htaccess`

Vérifiez que `public/.htaccess` existe et contient :

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

# Empêcher l'accès direct aux fichiers PHP dans certains dossiers
<FilesMatch "\.(env|log|ini)$">
    Order allow,deny
    Deny from all
</FilesMatch>
```

### 4.3 Générer APP_SECRET

Générez un secret aléatoire de 32 caractères :

```bash
# Sur Windows (PowerShell)
php -r "echo bin2hex(random_bytes(16));"

# Sur Linux/Mac
php -r "echo bin2hex(random_bytes(16));"
```

Copiez le résultat (ex: `a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6`)

### 4.4 Préparer le Fichier `.env`

Créez un fichier `.env.production` (ne le commitez pas) :

```env
APP_ENV=prod
APP_SECRET=votre_secret_32_caracteres_generes
DATABASE_URL="mysql://epiz_XXXXXX_amj_user:password@sqlXXX.epizy.com:3306/epiz_XXXXXX_amj_db?serverVersion=8.0.32&charset=utf8mb4"
```

**Remplacez** :
- `epiz_XXXXXX_amj_user` par votre username MySQL
- `password` par votre mot de passe MySQL
- `sqlXXX.epizy.com` par votre host MySQL
- `epiz_XXXXXX_amj_db` par votre nom de base de données

---

## 📤 Étape 5 : Upload des Fichiers {#upload-fichiers}

### 5.1 Méthode 1 : Via FTP (Recommandé)

#### Installer FileZilla

1. Téléchargez [FileZilla](https://filezilla-project.org/download.php?type=client)
2. Installez-le

#### Récupérer les Identifiants FTP

1. Dans le **Control Panel**, allez dans **"FTP Accounts"**
2. Notez :
   - **Host** : `ftpupload.net` (ou celui indiqué)
   - **Username** : `epiz_XXXXXX` (votre username principal)
   - **Password** : (votre mot de passe principal)
   - **Port** : `21`

#### Connecter FileZilla

1. Ouvrez FileZilla
2. Remplissez :
   ```
   Hôte : ftpupload.net
   Nom d'utilisateur : epiz_XXXXXX
   Mot de passe : votre_mot_de_passe
   Port : 21
   ```
3. Cliquez sur **"Connexion rapide"**

#### Uploader les Fichiers

1. **Côté gauche (Local)** : Naviguez vers votre dossier `symfony-amj`
2. **Côté droit (Serveur)** : Naviguez vers `htdocs/` ou `public_html/`
3. **Sélectionnez TOUS les fichiers et dossiers** :
   ```
   bin/
   config/
   public/
   src/
   templates/
   vendor/
   var/
   .env (celui que vous avez préparé)
   composer.json
   composer.lock
   symfony.lock
   ```
4. **Glissez-déposez** ou **Clic droit → Upload**
5. Attendez la fin de l'upload (peut prendre 10-30 minutes selon la taille)

### 5.2 Méthode 2 : Via File Manager

1. Dans le **Control Panel**, allez dans **"File Manager"**
2. Naviguez vers `htdocs/` ou `public_html/`
3. Cliquez sur **"Upload"**
4. Sélectionnez tous les fichiers de votre projet
5. Cliquez sur **"Upload Files"**
6. Attendez la fin de l'upload

### 5.3 Vérifier la Structure

Après l'upload, la structure doit être :

```
htdocs/ (ou public_html/)
├── bin/
├── config/
├── public/
│   ├── index.php
│   ├── .htaccess
│   └── assets/
├── src/
├── templates/
├── vendor/
├── var/
├── .env
├── composer.json
└── composer.lock
```

---

## ⚙️ Étape 6 : Configuration de l'Environnement {#configuration-env}

### 6.1 Créer le Fichier `.env` sur le Serveur

1. **Via File Manager** ou **FTP**, créez/modifiez le fichier `.env` dans `htdocs/`
2. Ajoutez le contenu (remplacez les valeurs) :

```env
APP_ENV=prod
APP_SECRET=votre_secret_32_caracteres
DATABASE_URL="mysql://epiz_XXXXXX_amj_user:password@sqlXXX.epizy.com:3306/epiz_XXXXXX_amj_db?serverVersion=8.0.32&charset=utf8mb4"
```

### 6.2 Créer `.htaccess` à la Racine (Important)

Créez un fichier `.htaccess` à la racine de `htdocs/` :

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    
    # Rediriger toutes les requêtes vers public/index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ public/index.php [QSA,L]
</IfModule>
```

**Pourquoi ?** : Cela permet à Symfony de gérer toutes les requêtes via `public/index.php`.

---

## 🗃️ Étape 7 : Exécution des Migrations {#execution-migrations}

### 7.1 Méthode 1 : Via Terminal (si disponible)

1. Dans le **Control Panel**, allez dans **"Advanced"** → **"Terminal"**
2. Connectez-vous via SSH
3. Naviguez vers votre projet :
```bash
cd ~/htdocs
# ou
cd ~/public_html
```
4. Exécutez les migrations :
```bash
php bin/console doctrine:migrations:migrate --no-interaction
```
5. Créez l'utilisateur admin :
```bash
php bin/console app:create-admin
```

### 7.2 Méthode 2 : Via Script PHP Temporaire

Si le Terminal n'est pas disponible, créez un fichier `setup.php` dans `htdocs/` :

```php
<?php
// setup.php - À SUPPRIMER APRÈS UTILISATION

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

// Charger .env
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

// Créer le kernel
$kernel = new App\Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
$kernel->boot();

// Créer l'application console
$application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
$application->setAutoExit(false);

echo "<h1>Setup Symfony</h1>";
echo "<p>Exécution des migrations...</p>";

try {
    // Exécuter les migrations
    $application->run(new \Symfony\Component\Console\Input\ArrayInput([
        'command' => 'doctrine:migrations:migrate',
        '--no-interaction' => true,
    ]));
    
    echo "<p style='color: green;'>✅ Migrations exécutées avec succès !</p>";
    
    // Créer l'admin
    $application->run(new \Symfony\Component\Console\Input\ArrayInput([
        'command' => 'app:create-admin',
    ]));
    
    echo "<p style='color: green;'>✅ Utilisateur admin créé !</p>";
    echo "<p style='color: red;'><strong>⚠️ IMPORTANT : Supprimez ce fichier setup.php maintenant !</strong></p>";
    
} catch (\Exception $e) {
    echo "<p style='color: red;'>❌ Erreur : " . $e->getMessage() . "</p>";
}
```

1. Accédez à : `https://votre-site.infinityfreeapp.com/setup.php`
2. Attendez que le script s'exécute
3. **SUPPRIMEZ IMMÉDIATEMENT** le fichier `setup.php` pour la sécurité

---

## 🔐 Étape 8 : Configuration des Permissions {#permissions}

### 8.1 Permissions Requises

Via **File Manager** ou **FTP**, configurez les permissions :

| Dossier/Fichier | Permission | Description |
|----------------|------------|-------------|
| `var/` | `775` | Cache et logs (lecture/écriture) |
| `var/cache/` | `775` | Cache Symfony |
| `var/log/` | `775` | Logs Symfony |
| `public/` | `755` | Point d'entrée public |
| `.env` | `644` | Variables d'environnement (lecture seule) |

### 8.2 Comment Modifier les Permissions

**Via File Manager** :
1. Clic droit sur le dossier → **"Change Permissions"**
2. Entrez `775` pour `var/`
3. Cliquez sur **"Change Permissions"**

**Via FTP (FileZilla)** :
1. Clic droit sur le dossier → **"File Attributes"**
2. Entrez `775`
3. Cochez **"Recurse into subdirectories"**
4. Cliquez sur **"OK"**

---

## ✅ Étape 9 : Test et Vérification {#test-verification}

### 9.1 Tester le Site

1. Allez sur : `https://votre-site.infinityfreeapp.com`
2. Testez les pages :
   - ✅ Page d'accueil : `/`
   - ✅ Page d'inscription : `/inscription`
   - ✅ Page de connexion : `/login`
   - ✅ Dashboard admin : `/admin/dashboard` (après connexion)

### 9.2 Vérifier la Base de Données

Utilisez la commande que nous avons créée :

```bash
php bin/console app:check-database
```

Ou via le script PHP temporaire (à créer) :

```php
<?php
// check-db.php - À SUPPRIMER APRÈS

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$kernel = new App\Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
$kernel->boot();

$application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
$application->setAutoExit(false);

$application->run(new \Symfony\Component\Console\Input\ArrayInput([
    'command' => 'app:check-database',
]));
```

Accédez à : `https://votre-site.infinityfreeapp.com/check-db.php`

---

## 🔧 Dépannage {#depannage}

### Erreur : "Database connection failed"

**Causes possibles** :
- ❌ `DATABASE_URL` incorrect
- ❌ Base de données n'existe pas
- ❌ Identifiants MySQL incorrects
- ❌ Host MySQL incorrect

**Solutions** :
1. Vérifiez `.env` sur le serveur
2. Vérifiez les informations dans cPanel → MySQL Databases
3. Testez la connexion via phpMyAdmin (si disponible)

### Erreur : "500 Internal Server Error"

**Causes possibles** :
- ❌ Permissions incorrectes sur `var/`
- ❌ `.env` mal configuré
- ❌ Erreur PHP

**Solutions** :
1. Vérifiez les logs : `var/log/prod.log`
2. Vérifiez les permissions de `var/` (doit être `775`)
3. Vérifiez `.env` (syntaxe correcte)
4. Activez le mode debug temporairement : `APP_DEBUG=true` dans `.env`

### Erreur : "Class not found" ou "Composer autoload"

**Causes possibles** :
- ❌ `vendor/` non uploadé
- ❌ `composer.json` manquant

**Solutions** :
1. Vérifiez que `vendor/` est bien uploadé
2. Si Terminal disponible, exécutez : `composer install --no-dev`

### Erreur : "Route not found"

**Causes possibles** :
- ❌ `.htaccess` mal configuré
- ❌ `public/index.php` non accessible

**Solutions** :
1. Vérifiez `.htaccess` à la racine et dans `public/`
2. Vérifiez que `public/index.php` existe
3. Testez l'accès direct : `https://votre-site.infinityfreeapp.com/public/index.php`

### Erreur : "Permission denied" sur `var/`

**Solutions** :
1. Modifiez les permissions de `var/` à `775`
2. Vérifiez que le propriétaire est correct (via File Manager)

---

## 🚀 Optimisations {#optimisations}

### 1. Activer le Cache Symfony

Le cache est automatiquement activé en production (`APP_ENV=prod`).

### 2. Optimiser les Assets

Minifiez vos CSS/JS si possible (manuellement ou via un outil).

### 3. Configurer un Domaine Personnalisé

1. Dans le **Control Panel**, allez dans **"Domains"**
2. Cliquez sur **"Add Domain"**
3. Entrez votre domaine
4. Suivez les instructions DNS
5. La publicité sera automatiquement désactivée

### 4. Faire des Backups Réguliers

1. Dans cPanel → **"Backup"**
2. Téléchargez régulièrement la base de données MySQL
3. Gardez une copie de vos fichiers importants

---

## ❓ FAQ {#faq}

### Q : Puis-je utiliser PostgreSQL au lieu de MySQL ?

**R :** Non, InfinityFree ne supporte que MySQL. Si vous avez besoin de PostgreSQL, utilisez Render.com ou Railway.app.

### Q : Comment désactiver la publicité ?

**R :** Ajoutez un domaine personnalisé (gratuit). La publicité sera automatiquement désactivée.

### Q : Puis-je utiliser un domaine personnalisé ?

**R :** Oui, c'est gratuit. Allez dans **"Domains"** → **"Add Domain"** et suivez les instructions DNS.

### Q : Quelle est la limite de stockage ?

**R :** InfinityFree offre un stockage illimité, mais avec des limites de CPU et RAM.

### Q : Puis-je utiliser SSH ?

**R :** Cela dépend de votre plan. Certains comptes ont accès à SSH, d'autres non. Vérifiez dans **"Advanced"** → **"Terminal"**.

### Q : Comment mettre à jour mon application ?

**R :** 
1. Faites les modifications en local
2. Testez en local
3. Uploader les fichiers modifiés via FTP
4. Exécutez les migrations si nécessaire : `php bin/console doctrine:migrations:migrate`

### Q : Mon site est lent, que faire ?

**R :** 
- Activez le cache Symfony (déjà fait en production)
- Optimisez vos images
- Vérifiez que `vendor/` est bien uploadé (pas besoin de le re-uploader à chaque fois)

---

## 📞 Support

### Support InfinityFree

- **Site** : [infinityfree.net](https://www.infinityfree.net)
- **Forum** : [forum.infinityfree.net](https://forum.infinityfree.net)
- **Documentation** : [infinityfree.net/support](https://www.infinityfree.net/support)

### Support Symfony

- **Documentation** : [symfony.com/doc](https://symfony.com/doc)
- **Stack Overflow** : Tag `symfony`

---

## ✅ Checklist Finale

- [ ] Compte InfinityFree créé et vérifié
- [ ] Site créé avec sous-domaine
- [ ] Base de données MySQL créée
- [ ] Utilisateur MySQL créé et associé à la base
- [ ] Application optimisée pour la production
- [ ] Fichiers uploadés via FTP
- [ ] `.env` configuré avec les bonnes informations
- [ ] `.htaccess` créé à la racine et dans `public/`
- [ ] Migrations exécutées
- [ ] Utilisateur admin créé
- [ ] Permissions configurées (`var/` = 775)
- [ ] Site testé et fonctionnel
- [ ] Fichiers temporaires (`setup.php`, `check-db.php`) supprimés

---

## 🎉 Félicitations !

Votre application Symfony est maintenant déployée sur InfinityFree avec MySQL !

**Prochaines étapes** :
1. Testez toutes les fonctionnalités
2. Configurez un domaine personnalisé (optionnel)
3. Faites des backups réguliers
4. Surveillez les logs pour détecter d'éventuels problèmes

---

**Documentation créée le** : 2024-12-07  
**Version** : 1.0  
**Compatible avec** : Symfony 6.4, PHP 8.2, MySQL 8.0

