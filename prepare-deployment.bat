@echo off
echo ========================================
echo Preparation pour le deploiement sur InfinityFree
echo ========================================
echo.

echo [1/4] Installation des dependances (sans dev)...
call composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo ERREUR: Echec de l'installation des dependances
    pause
    exit /b 1
)

echo.
echo [2/4] Vidage du cache...
call php bin/console cache:clear --env=prod
if %errorlevel% neq 0 (
    echo ERREUR: Echec du vidage du cache
    pause
    exit /b 1
)

echo.
echo [3/4] Generation du secret APP_SECRET...
php -r "echo 'APP_SECRET=' . bin2hex(random_bytes(16)) . PHP_EOL;"

echo.
echo [4/4] Verification des fichiers necessaires...
if exist ".htaccess" (
    echo [OK] .htaccess existe
) else (
    echo [ERREUR] .htaccess manquant
)

if exist "setup.php" (
    echo [OK] setup.php existe
) else (
    echo [ERREUR] setup.php manquant
)

if exist "public\.htaccess" (
    echo [OK] public\.htaccess existe
) else (
    echo [ATTENTION] public\.htaccess manquant
)

echo.
echo ========================================
echo ✅ Preparation terminee !
echo ========================================
echo.
echo Prochaines etapes :
echo.
echo 1. Creez le fichier .env avec vos informations MySQL :
echo    - APP_ENV=prod
echo    - APP_SECRET=(le secret genere ci-dessus)
echo    - DATABASE_URL="mysql://USER:PASS@HOST:3306/DB?serverVersion=8.0.32&charset=utf8mb4"
echo.
echo 2. Uploader TOUS les fichiers via FTP dans htdocs/
echo    - bin/, config/, public/, src/, templates/, vendor/, var/, .env, etc.
echo.
echo 3. Accedez a : https://votre-site.infinityfreeapp.com/setup.php
echo.
echo 4. Supprimez setup.php apres utilisation (securite)
echo.
echo 5. Configurez les permissions : var/ = 775
echo.
pause
