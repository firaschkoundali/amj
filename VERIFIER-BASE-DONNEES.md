# 🔍 Comment vérifier si la base de données est bien créée ?

## 📋 Méthodes de vérification

### 1️⃣ **Via les commandes Symfony (Recommandé)**

#### ✅ Vérifier la connexion à la base de données
```bash
php bin/console doctrine:database:create --if-not-exists
```
Si la base existe déjà, vous verrez : `Database `amj_db` already exists. Skipped.`

#### ✅ Lister toutes les tables
```bash
php bin/console doctrine:schema:validate
```
Cette commande vérifie si le schéma de la base de données correspond à vos entités.

#### ✅ Voir le statut des migrations
```bash
php bin/console doctrine:migrations:status
```
Affiche quelles migrations ont été exécutées.

#### ✅ Lister les tables créées
```bash
php bin/console doctrine:schema:update --dump-sql
```
Affiche les requêtes SQL qui seraient exécutées (sans les exécuter).

---

### 2️⃣ **Via l'interface Render (Production)**

#### Sur Render.com :

1. **Allez dans votre dashboard Render**
2. **Cliquez sur votre base de données** (`amj-db`)
3. **Vérifiez l'onglet "Info"** :
   - ✅ **Status** : Doit être `Available`
   - ✅ **Database Name** : `amj_db`
   - ✅ **User** : `amj_db_user`
   - ✅ **Internal Database URL** : Visible ici

4. **Vérifiez l'onglet "Logs"** :
   - Recherchez des erreurs de connexion
   - Vérifiez que la base est bien démarrée

5. **Vérifiez l'onglet "Connections"** :
   - Vérifiez que votre service web (`symfony-amj`) est bien connecté

---

### 3️⃣ **Via les logs de votre application**

#### Sur Render - Logs du service web :

1. Allez dans votre service web (`symfony-amj`)
2. Cliquez sur l'onglet **"Logs"**
3. Recherchez ces messages :

**✅ Si la base est bien créée et connectée :**
```
[info] User Deprecated: Please install the "intl" PHP extension for best performance.
[info] // Warming up the cache for the prod environment with debug false
[info] Cache warmed up successfully
```

**❌ Si la base n'est pas accessible :**
```
[critical] SQLSTATE[08006] [7] could not connect to server
[critical] Connection refused
[critical] database "amj_db" does not exist
```

---

### 4️⃣ **Via une commande de test personnalisée**

Créez une commande simple pour tester la connexion :

```bash
php bin/console dbal:run-sql "SELECT version();"
```

**Pour PostgreSQL :**
```bash
php bin/console dbal:run-sql "SELECT version();"
```

**Pour MySQL :**
```bash
php bin/console dbal:run-sql "SELECT VERSION();"
```

**Pour lister les tables :**
```bash
# PostgreSQL
php bin/console dbal:run-sql "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public';"

# MySQL
php bin/console dbal:run-sql "SHOW TABLES;"
```

---

### 5️⃣ **Via l'accès direct à la base (si disponible)**

#### Sur Render - PostgreSQL :

1. Allez dans votre base de données `amj-db`
2. Cliquez sur **"Connect"** ou **"psql"**
3. Render vous donnera une commande pour vous connecter
4. Une fois connecté, exécutez :
```sql
-- Lister les bases de données
\l

-- Se connecter à votre base
\c amj_db

-- Lister les tables
\dt

-- Voir le nombre de tables
SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'public';
```

---

### 6️⃣ **Via votre application Symfony**

#### Testez une page qui utilise la base de données :

1. **Page d'inscription** : `https://votre-app.onrender.com/inscription`
   - Si la page se charge sans erreur, la base est accessible
   - Si vous voyez une erreur de connexion, la base n'est pas accessible

2. **Page de connexion admin** : `https://votre-app.onrender.com/login`
   - Testez de vous connecter avec un compte admin

3. **Dashboard admin** : `https://votre-app.onrender.com/admin/dashboard`
   - Si vous voyez des données, la base fonctionne

---

## 🎯 Checklist rapide

### ✅ Base de données créée si :

- [ ] Le service de base de données sur Render affiche `Available`
- [ ] La commande `doctrine:database:create` dit que la base existe
- [ ] Les migrations ont été exécutées (`doctrine:migrations:migrate`)
- [ ] Les logs de l'application ne montrent pas d'erreurs de connexion
- [ ] Vous pouvez accéder aux pages qui utilisent la base de données

### ❌ Base de données non créée si :

- [ ] Le service de base de données affiche `Unavailable` ou `Error`
- [ ] Les logs montrent `could not connect to server`
- [ ] Les logs montrent `database does not exist`
- [ ] Les pages de l'application affichent des erreurs de connexion

---

## 🚀 Commandes à exécuter après le déploiement

Une fois votre application déployée sur Render, exécutez ces commandes via **Render Shell** :

1. **Créer la base de données** (si pas déjà fait) :
```bash
php bin/console doctrine:database:create --if-not-exists
```

2. **Exécuter les migrations** :
```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

3. **Créer un utilisateur admin** :
```bash
php bin/console app:create-admin
```

4. **Vérifier que tout fonctionne** :
```bash
php bin/console doctrine:schema:validate
```

---

## 📞 Comment accéder à Render Shell ?

1. Allez dans votre service web sur Render
2. Cliquez sur l'onglet **"Shell"**
3. Une console s'ouvre où vous pouvez exécuter des commandes
4. Naviguez vers votre application : `cd /opt/render/project/src` (ou le chemin approprié)

---

## 💡 Astuce

Si vous voulez automatiser la création de la base et l'exécution des migrations au démarrage, vous pouvez modifier le `Dockerfile` pour inclure ces commandes dans le `CMD` :

```dockerfile
CMD php bin/console doctrine:database:create --if-not-exists --no-interaction && \
    php bin/console doctrine:migrations:migrate --no-interaction && \
    php bin/console cache:clear --env=prod --no-interaction && \
    php bin/console cache:warmup --env=prod --no-interaction && \
    php -S 0.0.0.0:${PORT:-8000} -t public
```

Mais attention : cela peut ralentir le démarrage. Il est préférable de le faire manuellement la première fois.

