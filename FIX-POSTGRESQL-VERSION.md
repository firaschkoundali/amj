# 🔧 Fix : Version PostgreSQL dans DATABASE_URL

## Problème

L'erreur `Invalid platform version "" specified` indique que Doctrine ne peut pas détecter la version de PostgreSQL.

## Solution

Ajoutez la version de PostgreSQL directement dans votre `DATABASE_URL` sur Render.

### Sur Render - Variables d'environnement

Modifiez votre variable `DATABASE_URL` pour inclure la version :

**Ancienne valeur** :
```
postgresql://amj_db_user:2FiHBAFLGdMa0S8y7HabMXyJXvE6PcaN@dpg-d4qv9bqli9vc73a56s90-a/amj_db
```

**Nouvelle valeur** (avec version PostgreSQL) :
```
postgresql://amj_db_user:2FiHBAFLGdMa0S8y7HabMXyJXvE6PcaN@dpg-d4qv9bqli9vc73a56s90-a/amj_db?serverVersion=15
```

### Comment faire sur Render

1. Allez dans votre service sur Render
2. Cliquez sur **"Environment"**
3. Trouvez la variable `DATABASE_URL`
4. Modifiez-la pour ajouter `?serverVersion=15` à la fin
5. Cliquez sur **"Save Changes"**
6. Render redéploiera automatiquement

### Vérifier la version PostgreSQL

Si vous n'êtes pas sûr de la version, vous pouvez :
- Utiliser `15` (version la plus courante sur Render)
- Ou `16` si votre base de données est plus récente
- La version exacte est généralement visible dans l'interface Render de votre base de données

---

## Alternative : Configuration dans doctrine.yaml

Si vous préférez, vous pouvez aussi spécifier la version dans `config/packages/doctrine.yaml` :

```yaml
when@prod:
    doctrine:
        dbal:
            server_version: '15'
```

Mais la méthode avec `DATABASE_URL` est plus flexible.

---

## Pour MySQL en local

Pour votre environnement local avec MySQL, gardez votre `DATABASE_URL` comme :
```
mysql://user:password@127.0.0.1:3306/amj_db?serverVersion=8.0.32&charset=utf8mb4
```

Les deux fonctionneront sans conflit !

