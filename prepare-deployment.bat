@echo off
REM Script de préparation au déploiement pour Windows
REM Usage: prepare-deployment.bat

echo 🚀 Préparation de l'application pour le déploiement...

REM Installer les dépendances sans dev
echo 📦 Installation des dépendances de production...
composer install --no-dev --optimize-autoloader --no-interaction

REM Vider le cache
echo 🧹 Vidage du cache...
php bin/console cache:clear --env=prod --no-interaction

REM Réchauffer le cache
echo 🔥 Réchauffage du cache...
php bin/console cache:warmup --env=prod --no-interaction

echo ✅ Préparation terminée !
echo 📝 N'oubliez pas de :
echo    1. Configurer les variables d'environnement
echo    2. Exécuter les migrations : php bin/console doctrine:migrations:migrate
echo    3. Créer l'utilisateur admin : php bin/console app:create-admin-user

pause

