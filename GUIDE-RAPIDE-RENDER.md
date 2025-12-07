# 🚀 Guide Rapide - Déploiement sur Render.com (GRATUIT)

## Étape 1 : Préparer votre code

1. **Pousser votre code sur GitHub** (si pas déjà fait)
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin https://github.com/votre-username/votre-repo.git
   git push -u origin main
   ```

## Étape 2 : Créer un compte Render

1. Allez sur [render.com](https://render.com)
2. Créez un compte gratuit (avec GitHub)
3. Connectez votre repository GitHub

## Étape 3 : Créer la base de données

1. Dans le dashboard Render, cliquez sur **"New +"**
2. Sélectionnez **"PostgreSQL"**
3. Nommez-la : `symfony-db`
4. Plan : **Free**
5. Cliquez sur **"Create Database"**
6. **Notez** les informations de connexion (seront utilisées automatiquement)

## Étape 4 : Créer le Web Service

1. Cliquez sur **"New +"** → **"Web Service"**
2. Connectez votre repository GitHub
3. Sélectionnez votre repository
4. Configurez :

   **Name** : `symfony-amj`
   
   **Environment** : `PHP`
   
   **Region** : Choisissez le plus proche (ex: Frankfurt)
   
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

## Étape 5 : Configurer les variables d'environnement

Dans la section **"Environment"**, ajoutez :

```
APP_ENV=prod
APP_SECRET=votre_secret_aleatoire_32_caracteres
DATABASE_URL=postgresql://symfony:password@dpg-xxxxx-a/symfony
```

**Pour générer APP_SECRET** :
```bash
php -r "echo bin2hex(random_bytes(16));"
```

**Pour DATABASE_URL** : Render le génère automatiquement si vous utilisez `render.yaml`, sinon copiez-le depuis votre base de données PostgreSQL.

## Étape 6 : Déployer

1. Cliquez sur **"Create Web Service"**
2. Render va automatiquement :
   - Cloner votre code
   - Installer les dépendances
   - Démarrer votre application
3. Attendez 2-3 minutes pour le premier déploiement

## Étape 7 : Exécuter les migrations (après le déploiement)

1. Allez dans **"Shell"** de votre service
2. Exécutez :
   ```bash
   php bin/console doctrine:migrations:migrate --no-interaction
   ```

## Étape 8 : Créer l'utilisateur admin

Dans le **Shell** :
```bash
php bin/console app:create-admin-user
```

## ✅ C'est fait !

Votre application est maintenant accessible sur : `https://votre-app.onrender.com`

---

## 🔧 Configuration automatique avec render.yaml

Si vous avez le fichier `render.yaml` dans votre repo, Render le détectera automatiquement et configurera tout pour vous !

---

## ⚠️ Notes importantes

1. **Premier déploiement** : Peut prendre 3-5 minutes
2. **Service gratuit** : S'endort après 15 min d'inactivité (premier chargement sera lent)
3. **Limite** : 750 heures/mois gratuites (suffisant pour un site personnel)
4. **Base de données** : PostgreSQL gratuite avec 90 jours de rétention

---

## 🆘 Problèmes courants

### L'application ne démarre pas
- Vérifiez les logs dans Render
- Vérifiez que `APP_SECRET` est défini
- Vérifiez que `DATABASE_URL` est correct

### Erreur de base de données
- Vérifiez que la base de données est créée
- Vérifiez que `DATABASE_URL` est correct
- Exécutez les migrations

### Erreur 500
- Vérifiez les logs : `var/log/prod.log`
- Vérifiez les permissions des dossiers `var/` et `public/`

---

## 📚 Ressources

- [Documentation Render](https://render.com/docs)
- [Support Render](https://render.com/docs/support)

