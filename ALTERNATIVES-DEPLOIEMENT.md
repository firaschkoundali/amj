# 🚀 Alternatives de Déploiement Gratuit - Guide Comparatif

Ce guide compare les meilleures alternatives gratuites pour déployer votre application Symfony, en tenant compte de la compatibilité MySQL/PostgreSQL.

---

## 📊 Tableau Comparatif

| Plateforme | Gratuit | MySQL | PostgreSQL | Docker | Déploiement Auto | Difficulté |
|------------|---------|-------|------------|--------|------------------|------------|
| **InfinityFree** | ✅ 100% | ✅ | ❌ | ❌ | ❌ | ⭐ Facile |
| **000webhost** | ✅ 100% | ✅ | ❌ | ❌ | ❌ | ⭐ Facile |
| **Railway.app** | ✅ $5/mois | ✅ | ✅ | ✅ | ✅ | ⭐⭐ Moyen |
| **Fly.io** | ✅ 3 VMs | ✅ | ✅ | ✅ | ✅ | ⭐⭐⭐ Difficile |
| **Render.com** | ✅ 750h/mois | ❌ | ✅ | ✅ | ✅ | ⭐⭐ Moyen |
| **PlanetHoster** | ✅ 1 an | ✅ | ❌ | ❌ | ❌ | ⭐ Facile |
| **AlwaysData** | ✅ 100 Mo | ✅ | ✅ | ❌ | ❌ | ⭐⭐ Moyen |

---

## 🥇 Option 1 : InfinityFree (Recommandé pour MySQL)

### ✅ Avantages
- **100% gratuit** (sans limite de temps)
- **MySQL gratuit** inclus
- **Pas de problème de compatibilité** (même base en local et prod)
- **Facile à configurer**
- **Sous-domaine gratuit** (ex: `votre-site.infinityfreeapp.com`)

### ❌ Inconvénients
- **Publicité** sur le site (peut être désactivée avec un domaine personnalisé)
- **Limites de ressources** (CPU, RAM)
- **Pas de déploiement automatique** (FTP/File Manager)
- **Pas de Docker**

### 📋 Guide de Déploiement

#### Étape 1 : Créer un compte
1. Allez sur [infinityfree.net](https://www.infinityfree.net)
2. Créez un compte gratuit
3. Créez un nouveau site

#### Étape 2 : Configurer la base de données
1. Dans le panneau de contrôle, allez dans **"MySQL Databases"**
2. Créez une nouvelle base de données
3. Notez les informations :
   - **Host** : `sqlXXX.infinityfree.com` (ou `localhost`)
   - **Database** : `epiz_XXXXXX_nom`
   - **Username** : `epiz_XXXXXX`
   - **Password** : (celui que vous avez créé)

#### Étape 3 : Préparer l'application
1. **Optimiser pour la production** :
```bash
composer install --no-dev --optimize-autoloader
php bin/console cache:clear --env=prod
```

2. **Créer un fichier `.htaccess`** dans `public/` (si pas déjà présent) :
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>
```

#### Étape 4 : Uploader les fichiers
1. **Via FTP** (recommandé) :
   - Utilisez FileZilla ou un autre client FTP
   - Connectez-vous avec les identifiants fournis
   - Uploader tous les fichiers dans `htdocs/` ou `public_html/`

2. **Via File Manager** :
   - Allez dans le panneau de contrôle
   - Utilisez le gestionnaire de fichiers
   - Uploader les fichiers

#### Étape 5 : Configurer `.env`
Créez un fichier `.env` sur le serveur avec :
```env
APP_ENV=prod
APP_SECRET=votre_secret_32_caracteres_aleatoires
DATABASE_URL="mysql://epiz_XXXXXX:password@sqlXXX.infinityfree.com:3306/epiz_XXXXXX_nom?serverVersion=8.0.32&charset=utf8mb4"
```

#### Étape 6 : Exécuter les migrations
Via **cPanel** → **Terminal** ou **SSH** (si disponible) :
```bash
cd /home/username/htdocs
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console app:create-admin
```

---

## 🥈 Option 2 : Railway.app (Recommandé pour Flexibilité)

### ✅ Avantages
- **$5 de crédit gratuit/mois** (suffisant pour un petit projet)
- **MySQL ET PostgreSQL** disponibles
- **Déploiement automatique** depuis GitHub
- **Docker supporté**
- **Pas de publicité**
- **Excellent support**

### ❌ Inconvénients
- **Limite de crédit** (peut nécessiter un upgrade pour un site très fréquenté)
- **Configuration un peu plus complexe**

### 📋 Guide de Déploiement

#### Étape 1 : Créer un compte
1. Allez sur [railway.app](https://railway.app)
2. Créez un compte (avec GitHub)
3. Créez un nouveau projet

#### Étape 2 : Déployer depuis GitHub
1. Cliquez sur **"New Project"** → **"Deploy from GitHub repo"**
2. Sélectionnez votre repository
3. Railway détectera automatiquement Symfony

#### Étape 3 : Ajouter une base de données MySQL
1. Cliquez sur **"New"** → **"Database"** → **"Add MySQL"**
2. Railway créera automatiquement une base MySQL
3. La variable `DATABASE_URL` sera automatiquement ajoutée

#### Étape 4 : Configurer les variables d'environnement
Dans **"Variables"**, ajoutez :
```
APP_ENV=prod
APP_SECRET=votre_secret_32_caracteres
```

#### Étape 5 : Configurer le build
Railway détectera automatiquement Symfony, mais vous pouvez créer un `railway.json` :
```json
{
  "$schema": "https://railway.app/railway.schema.json",
  "build": {
    "builder": "NIXPACKS"
  },
  "deploy": {
    "startCommand": "php -S 0.0.0.0:$PORT -t public",
    "restartPolicyType": "ON_FAILURE"
  }
}
```

#### Étape 6 : Exécuter les migrations
Via **Railway Shell** :
```bash
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console app:create-admin
```

---

## 🥉 Option 3 : 000webhost (Alternative à InfinityFree)

### ✅ Avantages
- **100% gratuit**
- **MySQL gratuit**
- **Pas de publicité** (contrairement à InfinityFree)
- **cPanel inclus**
- **Facile à utiliser**

### ❌ Inconvénients
- **Limites de ressources**
- **Pas de déploiement automatique**
- **Pas de Docker**

### 📋 Guide Rapide

1. Créez un compte sur [000webhost.com](https://www.000webhost.com)
2. Créez un site
3. Configurez MySQL via cPanel
4. Uploader les fichiers via FTP ou File Manager
5. Configurez `.env` avec les informations MySQL
6. Exécutez les migrations via Terminal cPanel

---

## 🔧 Option 4 : AlwaysData (Recommandé pour Professionnel)

### ✅ Avantages
- **100 Mo gratuit** (suffisant pour Symfony)
- **MySQL ET PostgreSQL**
- **SSH inclus**
- **Pas de publicité**
- **Très professionnel**

### ❌ Inconvénients
- **Limite d'espace** (100 Mo)
- **Configuration plus complexe**

### 📋 Guide Rapide

1. Créez un compte sur [alwaysdata.com](https://www.alwaysdata.com)
2. Créez une base de données MySQL
3. Configurez SSH
4. Clonez votre repository via SSH
5. Configurez `.env`
6. Exécutez les migrations

---

## 🎯 Recommandation Finale

### Pour éviter les problèmes MySQL/PostgreSQL :

**Option A : Utiliser MySQL partout (Recommandé pour simplicité)**
- ✅ **InfinityFree** ou **000webhost** (gratuit, MySQL)
- ✅ Même base en local et production
- ✅ Pas de problème de migrations
- ✅ Facile à configurer

**Option B : Utiliser PostgreSQL partout**
- ✅ **Render.com** ou **Fly.io** (gratuit, PostgreSQL)
- ✅ Utiliser PostgreSQL en local aussi (via Docker)
- ✅ Plus professionnel
- ⚠️ Nécessite de modifier votre setup local

**Option C : Solution hybride (Flexibilité)**
- ✅ **Railway.app** (supporte les deux)
- ✅ Vous pouvez choisir MySQL ou PostgreSQL
- ✅ Déploiement automatique
- ⚠️ Limite de crédit

---

## 📝 Checklist de Migration

Quelle que soit la plateforme choisie :

- [ ] Compte créé sur la plateforme
- [ ] Base de données créée (MySQL ou PostgreSQL)
- [ ] Variables d'environnement configurées (`APP_ENV`, `APP_SECRET`, `DATABASE_URL`)
- [ ] Code uploadé/déployé
- [ ] Migrations exécutées (`doctrine:migrations:migrate`)
- [ ] Utilisateur admin créé (`app:create-admin`)
- [ ] Cache vidé et réchauffé
- [ ] Site testé et fonctionnel

---

## 🆘 Support

En cas de problème :
1. Vérifiez les logs de la plateforme
2. Vérifiez les variables d'environnement
3. Vérifiez la connexion à la base de données
4. Utilisez la commande `app:check-database` pour diagnostiquer

---

## 💡 Astuce Pro

**Pour tester rapidement** : Utilisez **InfinityFree** ou **000webhost** pour un déploiement rapide avec MySQL, puis migrez vers **Railway.app** ou **Render.com** si vous avez besoin de plus de ressources ou de PostgreSQL.

