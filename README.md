# Site Web AMJ - Amicale des Médecins de Jerba

Site web pour la gestion des 16èmes Journées Médicales de l'AMJ (Amicale des Médecins de Jerba).

## 🎯 Projet

Site vitrine développé avec Symfony 6.4 pour présenter le congrès médical et permettre l'inscription en ligne des médecins.

## 🚀 Installation

### Prérequis
- PHP 8.2 ou supérieur
- Composer
- MySQL/PostgreSQL (pour la base de données)

### Étapes d'installation

1. **Cloner ou naviguer vers le projet**
```bash
cd symfony-amj
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer la base de données**
   - Créer un fichier `.env.local` à partir de `.env`
   - Modifier la variable `DATABASE_URL` :
   ```env
   DATABASE_URL="mysql://user:password@127.0.0.1:3306/amj_db?serverVersion=8.0.32&charset=utf8mb4"
   ```

4. **Créer la base de données**
```bash
php bin/console doctrine:database:create
```

5. **Créer les tables (migrations)**
```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

6. **Lancer le serveur de développement**
```bash
symfony server:start
# ou
php -S localhost:8000 -t public
```

7. **Créer un utilisateur administrateur**
```bash
php bin/console app:create-admin
# Ou avec des paramètres personnalisés :
php bin/console app:create-admin --email=votre@email.com --password=votreMotDePasse --nom=VotreNom --prenom=VotrePrenom
```

8. **Accéder au site**
   - Page d'accueil : `http://localhost:8000`
   - Page d'inscription : `http://localhost:8000/inscription`
   - Page de connexion admin : `http://localhost:8000/login`
   - Dashboard admin : `http://localhost:8000/admin/dashboard`

## 📁 Structure du projet

```
symfony-amj/
├── config/              # Configuration Symfony
├── public/              # Point d'entrée public
│   └── assets/         # Assets statiques (CSS, JS, images)
├── src/
│   ├── Command/         # Commandes Symfony
│   │   └── CreateAdminUserCommand.php
│   ├── Controller/      # Contrôleurs
│   │   ├── HomeController.php
│   │   ├── RegistrationController.php
│   │   ├── SecurityController.php
│   │   └── AdminController.php
│   ├── Entity/          # Entités Doctrine
│   │   ├── Medecin.php
│   │   └── User.php
│   ├── Form/            # Formulaires Symfony
│   │   └── MedecinType.php
│   └── Repository/       # Repositories Doctrine
│       ├── MedecinRepository.php
│       └── UserRepository.php
├── templates/           # Templates Twig
│   ├── base.html.twig   # Template de base
│   ├── home/            # Templates de la page d'accueil
│   ├── registration/    # Templates d'inscription
│   │   └── register.html.twig
│   ├── security/        # Templates d'authentification
│   │   └── login.html.twig
│   └── admin/           # Templates du dashboard admin
│       ├── dashboard.html.twig
│       └── medecin_show.html.twig
└── var/                 # Fichiers temporaires et cache
```

## 🎨 Design

Le design a été adapté selon le logo AMJ avec les couleurs suivantes :
- **Bleu AMJ** : `#0066CC` (couleur principale)
- **Rouge AMJ** : `#CC0000` (couleur d'accent)

Ces couleurs sont définies dans `public/assets/css/main.css` via les variables CSS :
- `--heading-color: #0066CC`
- `--accent-color: #CC0000`
- `--amj-blue: #0066CC`
- `--amj-red: #CC0000`

## 📋 Fonctionnalités actuelles

### Phase 1 : Site vitrine ✅
- Page d'accueil avec sections :
  - Hero section
  - À propos de l'événement
  - Conférenciers
  - Programme (2 jours)
  - Lieu de l'événement
  - Tarifs d'inscription
  - Contact

### Phase 2 : Système d'inscription ✅
- **Page d'inscription** (`/inscription`) :
  - Formulaire d'inscription avec validation
  - Champs : Nom, Prénom, Téléphone, Email, Spécialité, Lieu de travail
  - Vérification des doublons (email unique)
  - Design responsive et mobile-friendly
  - Messages de confirmation/erreur
  - Stockage en base de données

### Phase 3 : Dashboard Administrateur ✅
- **Système d'authentification** :
  - Page de connexion sécurisée (`/login`)
  - Protection des routes admin
- **Dashboard Admin** (`/admin/dashboard`) :
  - Liste complète des médecins inscrits
  - Statistiques (total, aujourd'hui, cette semaine)
  - Recherche par nom, prénom, email, spécialité
  - Vue détaillée de chaque médecin
  - Design moderne et responsive

### Phase 4 : À développer
- Inscription manuelle des médecins existants
- Génération de reçus PDF
- Export des données (Excel, CSV)

## 📚 Documentation

Voir le fichier `SPECIFICATIONS_FONCTIONNELLES.md` à la racine du projet pour la documentation complète des fonctionnalités.

## 🔧 Commandes utiles

```bash
# Créer un utilisateur administrateur
php bin/console app:create-admin
php bin/console app:create-admin --email=votre@email.com --password=votreMotDePasse

# Créer une entité
php bin/console make:entity

# Créer un contrôleur
php bin/console make:controller

# Créer une migration
php bin/console make:migration

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

# Vider le cache
php bin/console cache:clear
```

## 📝 Prochaines étapes

1. ✅ Créer les entités (Medecin, User)
2. ✅ Implémenter le formulaire d'inscription
3. ✅ Créer le système d'authentification admin
4. ✅ Développer le dashboard administrateur
5. Implémenter la génération de reçus PDF
6. Ajouter l'inscription manuelle des médecins existants
7. Exporter les données (Excel, CSV)

## 👥 Contact

Pour toute question concernant le projet, contactez l'équipe de développement.

---

**AMJ Djerba 2026** - Les grands experts du domaine scientifique sont parmi nous. Les sommites sont toujours à Djerba.

