# 🔧 Configuration de la Base de Données PostgreSQL sur Render

## ✅ Informations de votre base de données

- **Hostname interne** : `dpg-d4qv9bqli9vc73a56s90-a`
- **Port** : `5432`
- **Database** : `amj_db`
- **Username** : `amj_db_user`
- **Password** : `2FiHBAFLGdMa0S8y7HabMXyJXvE6PcaN`
- **URL interne** : `postgresql://amj_db_user:2FiHBAFLGdMa0S8y7HabMXyJXvE6PcaN@dpg-d4qv9bqli9vc73a56s90-a/amj_db`

## 📋 Étapes pour configurer sur Render

### Étape 1 : Mettre à jour le render.yaml

Le fichier `render.yaml` a été mis à jour avec le nom de votre base de données (`amj-db`).

### Étape 2 : Créer le Web Service sur Render

1. Allez sur [render.com](https://render.com)
2. Cliquez sur **"New +"** → **"Web Service"**
3. Connectez votre repository GitHub
4. Sélectionnez votre repository `symfony-amj`

### Étape 3 : Configurer le service

Render détectera automatiquement le fichier `render.yaml` et configurera :
- ✅ La connexion à la base de données `amj-db`
- ✅ Les variables d'environnement
- ✅ Les commandes de build et start

**OU** configurez manuellement :

**Build Command** :
```bash
composer install --no-dev --optimize-autoloader && php bin/console cache:clear --env=prod && php bin/console cache:warmup --env=prod
```

**Start Command** :
```bash
php -S 0.0.0.0:$PORT -t public
```

### Étape 4 : Variables d'environnement

Si vous configurez manuellement, ajoutez ces variables :

```
APP_ENV=prod
APP_SECRET=votre_secret_32_caracteres
DATABASE_URL=postgresql://amj_db_user:2FiHBAFLGdMa0S8y7HabMXyJXvE6PcaN@dpg-d4qv9bqli9vc73a56s90-a/amj_db
```

**Pour générer APP_SECRET** :
```bash
php -r "echo bin2hex(random_bytes(16));"
```

### Étape 5 : Après le déploiement

Une fois le service déployé, exécutez les migrations :

1. Allez dans votre service sur Render
2. Cliquez sur **"Shell"**
3. Exécutez :
```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

4. Créez l'utilisateur admin :
```bash
php bin/console app:create-admin-user
```

---

## ⚠️ MySQL en local vs PostgreSQL en production

### ✅ C'est possible, mais attention !

**Doctrine ORM** supporte les deux bases de données, mais il y a quelques différences :

### Différences à connaître :

1. **Types de données** :
   - MySQL : `TEXT`, `VARCHAR(255)`
   - PostgreSQL : `TEXT`, `VARCHAR(255)` (compatible)

2. **Auto-increment** :
   - MySQL : `AUTO_INCREMENT`
   - PostgreSQL : `SERIAL` ou `GENERATED ALWAYS AS IDENTITY`
   - ✅ **Doctrine gère ça automatiquement !**

3. **Quotes** :
   - MySQL : Backticks `` ` `` pour les identifiants
   - PostgreSQL : Double quotes `"` pour les identifiants
   - ✅ **Doctrine gère ça automatiquement !**

4. **Fonctions SQL** :
   - Certaines fonctions diffèrent (ex: `DATE_FORMAT` vs `TO_CHAR`)
   - ⚠️ **Vérifiez vos requêtes personnalisées**

### ✅ Bonne nouvelle !

Votre code utilise **Doctrine ORM** qui :
- ✅ Génère automatiquement le bon SQL selon la base de données
- ✅ Gère les différences de syntaxe
- ✅ Les migrations fonctionnent avec les deux

### ⚠️ Points à vérifier :

1. **Requêtes DQL personnalisées** : Vérifiez qu'elles sont compatibles
2. **Requêtes SQL brutes** : Peuvent nécessiter des ajustements
3. **Fonctions SQL natives** : Vérifiez la compatibilité

### 🔍 Vérification de votre code

Votre code semble utiliser uniquement Doctrine ORM standard, donc **ça devrait fonctionner sans problème** !

---

## 🧪 Tester en local avec PostgreSQL (optionnel)

Si vous voulez tester avec PostgreSQL en local aussi :

1. **Installer PostgreSQL** localement
2. **Créer une base de données** :
```bash
createdb amj_db_local
```

3. **Mettre à jour `.env.local`** :
```env
DATABASE_URL="postgresql://postgres:password@127.0.0.1:5432/amj_db_local"
```

4. **Exécuter les migrations** :
```bash
php bin/console doctrine:migrations:migrate
```

---

## 📝 Résumé

✅ **Vous pouvez utiliser MySQL en local et PostgreSQL en production**
✅ **Doctrine gère automatiquement les différences**
✅ **Votre code devrait fonctionner sans modification**

⚠️ **Vérifiez** si vous avez des requêtes SQL brutes ou des fonctions spécifiques à MySQL

---

## 🚀 Prochaines étapes

1. ✅ Base de données créée sur Render
2. ⏭️ Créer le Web Service sur Render
3. ⏭️ Configurer les variables d'environnement
4. ⏭️ Déployer
5. ⏭️ Exécuter les migrations
6. ⏭️ Créer l'utilisateur admin

