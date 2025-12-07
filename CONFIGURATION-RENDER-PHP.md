# 🔧 Configuration Render pour PHP/Symfony

## ⚠️ PHP n'apparaît pas dans la liste ?

Sur Render, PHP n'est pas toujours visible dans la liste des langages. Voici **3 solutions** :

---

## ✅ Solution 1 : Utiliser Docker (Recommandé)

### Configuration dans Render :

1. **Language** : Sélectionnez **"Docker"**
2. **Build Command** : (laissez vide, Dockerfile gère tout)
3. **Start Command** : (laissez vide, Dockerfile gère tout)
4. **Dockerfile Path** : `Dockerfile` (ou `./Dockerfile`)

Le fichier `Dockerfile` a été créé et configuré automatiquement !

### Avantages :
- ✅ Contrôle total sur l'environnement PHP
- ✅ Toutes les extensions nécessaires installées
- ✅ Configuration optimale pour Symfony

---

## ✅ Solution 2 : Configuration manuelle avec "Docker"

Si vous voulez configurer manuellement :

1. **Language** : **"Docker"**
2. **Build Command** : (laissez vide)
3. **Start Command** : (laissez vide)
4. **Dockerfile Path** : `Dockerfile`

Render utilisera automatiquement le `Dockerfile` que nous avons créé.

---

## ✅ Solution 3 : Utiliser Nixpacks (Alternative)

Si Docker ne fonctionne pas, vous pouvez utiliser Nixpacks :

1. **Language** : Sélectionnez **"Docker"**
2. Créez un fichier `nixpacks.toml` à la racine :

```toml
[phases.setup]
nixPkgs = ["php82", "composer"]

[phases.install]
cmds = ["composer install --no-dev --optimize-autoloader"]

[start]
cmd = "php -S 0.0.0.0:$PORT -t public"
```

3. **Build Command** : (laissez vide)
4. **Start Command** : (laissez vide)

---

## 📋 Configuration complète dans Render

### Champs à remplir :

1. **Source Code** : `firaschkoundali / amj` ✅ (déjà configuré)

2. **Name** : `symfony-amj` ou `amj`

3. **Language** : **"Docker"** ⚠️ (pas PHP directement)

4. **Branch** : `main` ou `master` (selon votre branche GitHub)

5. **Region** : `Frankfurt` (ou le plus proche)

6. **Root Directory** : (laissez vide)

7. **Build Command** : (laissez vide - Dockerfile gère tout)

8. **Start Command** : (laissez vide - Dockerfile gère tout)

9. **Dockerfile Path** : `Dockerfile`

### Variables d'environnement :

Dans la section **"Environment"**, ajoutez :

```
APP_ENV=prod
APP_SECRET=votre_secret_32_caracteres
DATABASE_URL=postgresql://amj_db_user:2FiHBAFLGdMa0S8y7HabMXyJXvE6PcaN@dpg-d4qv9bqli9vc73a56s90-a/amj_db
```

**Pour générer APP_SECRET** :
```bash
php -r "echo bin2hex(random_bytes(16));"
```

### Lier la base de données :

1. Dans la section **"Environment"**, cliquez sur **"Link Resource"**
2. Sélectionnez votre base de données : `amj-db`
3. Render ajoutera automatiquement `DATABASE_URL`

---

## 🚀 Après la création

1. Cliquez sur **"Create Web Service"**
2. Render va :
   - Construire l'image Docker
   - Installer les dépendances
   - Démarrer l'application
3. ⏳ Attendez 5-10 minutes pour le premier déploiement

---

## 🔧 Si vous préférez sans Docker

Vous pouvez aussi créer un service "Web Service" et utiliser ces commandes :

**Build Command** :
```bash
curl -sS https://getcomposer.org/installer | php && php composer.phar install --no-dev --optimize-autoloader && php bin/console cache:clear --env=prod && php bin/console cache:warmup --env=prod
```

**Start Command** :
```bash
php -S 0.0.0.0:$PORT -t public
```

Mais **Docker est recommandé** car plus fiable et prévisible.

---

## ✅ Résumé

**Choisissez "Docker" dans la liste des langages** - c'est la meilleure option pour PHP/Symfony sur Render !

Le `Dockerfile` est déjà créé et configuré pour votre application.

