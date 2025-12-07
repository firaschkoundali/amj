#!/bin/bash

# Script de préparation au déploiement
# Usage: ./prepare-deployment.sh

echo "🚀 Préparation de l'application pour le déploiement..."

# Installer les dépendances sans dev
echo "📦 Installation des dépendances de production..."
composer install --no-dev --optimize-autoloader --no-interaction

# Vider le cache
echo "🧹 Vidage du cache..."
php bin/console cache:clear --env=prod --no-interaction

# Réchauffer le cache
echo "🔥 Réchauffage du cache..."
php bin/console cache:warmup --env=prod --no-interaction

# Vérifier les permissions
echo "🔐 Vérification des permissions..."
chmod -R 775 var/
chmod -R 775 public/

echo "✅ Préparation terminée !"
echo "📝 N'oubliez pas de :"
echo "   1. Configurer les variables d'environnement"
echo "   2. Exécuter les migrations : php bin/console doctrine:migrations:migrate"
echo "   3. Créer l'utilisateur admin : php bin/console app:create-admin-user"

