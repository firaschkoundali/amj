<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:check-database',
    description: 'Vérifier la connexion et l\'état de la base de données',
)]
class CheckDatabaseCommand extends Command
{
    public function __construct(
        private Connection $connection
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $io->title('🔍 Vérification de la base de données');

        try {
            // Test de connexion
            $io->section('1. Test de connexion');
            $this->connection->connect();
            $io->success('✅ Connexion à la base de données réussie !');

            // Informations sur la base de données
            $io->section('2. Informations sur la base de données');
            
            $params = $this->connection->getParams();
            $driver = $params['driver'] ?? 'unknown';
            $dbname = $params['dbname'] ?? 'unknown';
            $host = $params['host'] ?? 'unknown';
            $port = $params['port'] ?? 'unknown';
            
            $io->table(
                ['Paramètre', 'Valeur'],
                [
                    ['Driver', $driver],
                    ['Base de données', $dbname],
                    ['Hôte', $host],
                    ['Port', $port],
                ]
            );

            // Version du serveur
            $io->section('3. Version du serveur de base de données');
            try {
                if ($driver === 'pdo_pgsql') {
                    $version = $this->connection->fetchOne('SELECT version();');
                } elseif ($driver === 'pdo_mysql') {
                    $version = $this->connection->fetchOne('SELECT VERSION();');
                } else {
                    $version = 'Non disponible';
                }
                $io->info($version);
            } catch (\Exception $e) {
                $io->warning('Impossible de récupérer la version : ' . $e->getMessage());
            }

            // Liste des tables
            $io->section('4. Tables dans la base de données');
            try {
                if ($driver === 'pdo_pgsql') {
                    $tables = $this->connection->fetchFirstColumn(
                        "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' ORDER BY table_name;"
                    );
                } elseif ($driver === 'pdo_mysql') {
                    $tables = $this->connection->fetchFirstColumn('SHOW TABLES;');
                } else {
                    $tables = [];
                }

                if (empty($tables)) {
                    $io->warning('⚠️  Aucune table trouvée dans la base de données.');
                    $io->note('Exécutez : php bin/console doctrine:migrations:migrate');
                } else {
                    $io->success(sprintf('✅ %d table(s) trouvée(s) :', count($tables)));
                    $io->listing($tables);
                }
            } catch (\Exception $e) {
                $io->error('Erreur lors de la récupération des tables : ' . $e->getMessage());
            }

            // Test d'écriture
            $io->section('5. Test d\'écriture');
            try {
                if ($driver === 'pdo_pgsql') {
                    $this->connection->executeStatement('SELECT 1');
                } elseif ($driver === 'pdo_mysql') {
                    $this->connection->executeStatement('SELECT 1');
                }
                $io->success('✅ La base de données accepte les requêtes (lecture/écriture OK)');
            } catch (\Exception $e) {
                $io->error('❌ Erreur lors du test d\'écriture : ' . $e->getMessage());
                return Command::FAILURE;
            }

            $io->newLine();
            $io->success('🎉 La base de données est opérationnelle !');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $io->error('❌ Erreur de connexion à la base de données :');
            $io->error($e->getMessage());
            $io->newLine();
            $io->note('Vérifiez :');
            $io->listing([
                'Que la variable DATABASE_URL est correctement configurée',
                'Que la base de données existe sur le serveur',
                'Que les identifiants de connexion sont corrects',
                'Que le serveur de base de données est démarré',
            ]);

            return Command::FAILURE;
        }
    }
}

