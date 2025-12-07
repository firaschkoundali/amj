<?php
/**
 * Script de configuration initiale pour InfinityFree
 * ⚠️ À SUPPRIMER APRÈS UTILISATION pour la sécurité !
 */

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

// Charger .env
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

// Créer le kernel
$kernel = new App\Kernel($_ENV['APP_ENV'], (bool) $_ENV['APP_DEBUG']);
$kernel->boot();

// Créer l'application console
$application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
$application->setAutoExit(false);

echo "<!DOCTYPE html>
<html>
<head>
    <title>Setup Symfony - InfinityFree</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #155724; background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #28a745; }
        .error { color: #721c24; background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #dc3545; }
        .warning { color: #856404; background: #fff3cd; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #ffc107; }
        .info { color: #004085; background: #d1ecf1; padding: 15px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #17a2b8; }
        h1 { color: #333; border-bottom: 3px solid #0052A3; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 20px; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: 'Courier New', monospace; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class='container'>
    <h1>🔧 Configuration Symfony - InfinityFree</h1>";

try {
    // 1. Exécuter les migrations
    echo "<h2>1. Exécution des migrations...</h2>";
    $application->run(new \Symfony\Component\Console\Input\ArrayInput([
        'command' => 'doctrine:migrations:migrate',
        '--no-interaction' => true,
    ]));
    echo "<div class='success'>✅ Migrations exécutées avec succès !</div>";
    
    // 2. Créer l'utilisateur admin
    echo "<h2>2. Création de l'utilisateur admin...</h2>";
    $application->run(new \Symfony\Component\Console\Input\ArrayInput([
        'command' => 'app:create-admin',
    ]));
    echo "<div class='success'>✅ Utilisateur admin créé avec succès !</div>";
    
    // 3. Vérifier la base de données
    echo "<h2>3. Vérification de la base de données...</h2>";
    try {
        $application->run(new \Symfony\Component\Console\Input\ArrayInput([
            'command' => 'app:check-database',
        ]));
    } catch (\Exception $e) {
        echo "<div class='info'>ℹ️ Commande de vérification non disponible, mais les migrations ont réussi.</div>";
    }
    
    echo "<div class='warning'>
        <strong>⚠️ IMPORTANT :</strong><br>
        Supprimez ce fichier <code>setup.php</code> maintenant pour la sécurité !<br>
        Vous pouvez le supprimer via FTP ou File Manager.
    </div>";
    
    echo "<div class='info'>
        <strong>✅ Configuration terminée !</strong><br>
        Votre site est maintenant prêt. Accédez à la page d'accueil pour tester.
    </div>";
    
} catch (\Exception $e) {
    echo "<div class='error'>
        <strong>❌ Erreur :</strong><br>
        " . htmlspecialchars($e->getMessage()) . "<br><br>
        <strong>Détails :</strong><br>
        <pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>
    </div>";
    
    echo "<div class='info'>
        <strong>💡 Aide :</strong><br>
        - Vérifiez que le fichier .env contient les bonnes informations MySQL<br>
        - Vérifiez que la base de données existe sur InfinityFree<br>
        - Vérifiez les permissions du dossier var/ (doit être 775)
    </div>";
}

echo "</div></body></html>";
?>

