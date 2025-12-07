# 🚀 Étapes de Déploiement - Application Symfony AMJ

## ✅ Ce qui est déjà fait

1. ✅ Base de données PostgreSQL créée sur Render
2. ✅ Code poussé sur GitHub (ou prêt à être poussé)
3. ✅ Fichier `render.yaml` configuré
4. ✅ Code compatible MySQL/PostgreSQL

## 📋 Étapes pour déployer sur Render

### Étape 1 : Créer le Web Service

1. Allez sur [render.com](https://render.com)
2. Cliquez sur **"New +"** → **"Web Service"**
3. **Connectez votre repository GitHub** :
   - Si pas encore connecté, cliquez sur "Connect GitHub"
   - Autorisez Render à accéder à vos repositories
4. **Sélectionnez votre repository** : `symfony-amj`

### Étape 2 : Configuration automatique (recommandé)

Si vous avez le fichier `render.yaml` dans votre repo, Render le détectera automatiquement !

**Render va automatiquement** :
- ✅ Détecter que c'est une application PHP
- ✅ Configurer la connexion à la base de données `amj-db`
- ✅ Ajouter les variables d'environnement
- ✅ Configurer les commandes de build et start

**Cliquez simplement sur "Create Web Service"** et Render fera le reste !

### Étape 3 : Configuration manuelle (si nécessaire)

Si Render ne détecte pas automatiquement le `render.yaml`, configurez manuellement :

**Name** : `symfony-amj`

**Environment** : `PHP`

**Region** : `Frankfurt` (ou le plus proche de vous)

**Branch** : `main` (ou `master`)

**Root Directory** : (laissez vide)

**Build Command** :
```bash
composer install --no-dev --optimize-autoloader && php bin/console cache:clear --env=prod && php bin/console cache:warmup --env=prod
```

**Start Command** :
```bash
php -S 0.0.0.0:$PORT -t public
```

### Étape 4 : Variables d'environnement

Si configuration manuelle, ajoutez ces variables dans la section "Environment" :

```
APP_ENV=prod
APP_SECRET=votre_secret_32_caracteres
DATABASE_URL=postgresql://amj_db_user:2FiHBAFLGdMa0S8y7HabMXyJXvE6PcaN@dpg-d4qv9bqli9vc73a56s90-a/amj_db
```

**Pour générer APP_SECRET** :
```bash
php -r "echo bin2hex(random_bytes(16));"
```

### Étape 5 : Lier la base de données

1. Dans la section "Environment", cliquez sur "Link Resource"
2. Sélectionnez votre base de données : `amj-db`
3. Render ajoutera automatiquement `DATABASE_URL`

### Étape 6 : Déployer

1. Cliquez sur **"Create Web Service"**
2. Render va :
   - Cloner votre code
   - Installer les dépendances
   - Démarrer votre application
3. ⏳ Attendez 3-5 minutes pour le premier déploiement

### Étape 7 : Exécuter les migrations

Une fois le déploiement terminé :

1. Allez dans votre service sur Render
2. Cliquez sur l'onglet **"Shell"**
3. Exécutez les migrations :
```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

4. Créez l'utilisateur admin :
```bash
php bin/console app:create-admin-user
```

### Étape 8 : Vérifier

1. Allez sur l'URL de votre service (ex: `https://symfony-amj.onrender.com`)
2. Vérifiez que l'application fonctionne
3. Testez l'inscription
4. Testez la connexion admin

---

## ✅ MySQL en local vs PostgreSQL en production

### C'est compatible ! ✅

**Votre code est maintenant compatible avec les deux bases de données** :

1. ✅ **Doctrine ORM** gère automatiquement les différences
2. ✅ **Les requêtes DQL** sont compatibles
3. ✅ **Les migrations** fonctionnent avec les deux
4. ✅ **Les fonctions CONCAT** ont été corrigées

### Ce qui a été corrigé :

- ❌ `CONCAT()` (spécifique MySQL) → ✅ Requêtes compatibles avec les deux
- ✅ Toutes les autres requêtes utilisent Doctrine Query Builder (compatible)

### Vous pouvez continuer à utiliser :

- **MySQL en local** pour le développement
- **PostgreSQL en production** sur Render

**Doctrine gère automatiquement les différences !**

---

## 🔧 Commandes utiles après déploiement

Dans le **Shell** de Render :

```bash
# Vider le cache
php bin/console cache:clear --env=prod

# Réchauffer le cache
php bin/console cache:warmup --env=prod

# Voir les logs
tail -f var/log/prod.log

# Exécuter les migrations
php bin/console doctrine:migrations:migrate --no-interaction

# Créer un utilisateur admin
php bin/console app:create-admin-user
```

---

## 🆘 Problèmes courants

### L'application ne démarre pas
- Vérifiez les logs dans Render
- Vérifiez que `APP_SECRET` est défini
- Vérifiez que `DATABASE_URL` est correct

### Erreur de connexion à la base de données
- Vérifiez que la base de données est liée au service
- Vérifiez que `DATABASE_URL` utilise l'URL interne (pas externe)
- Vérifiez que les migrations sont exécutées

### Erreur 500
- Vérifiez les logs : `var/log/prod.log`
- Vérifiez les permissions des dossiers `var/` et `public/`
- Vérifiez que le cache est réchauffé

---

## 📚 Ressources

- [Documentation Render](https://render.com/docs)
- [Documentation Symfony - Déploiement](https://symfony.com/doc/current/deployment.html)
- [Doctrine - Différences MySQL/PostgreSQL](https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/platforms.html)

