<?php

namespace App\Repository;

use App\Entity\Medecin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Medecin>
 */
class MedecinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medecin::class);
    }

    /**
     * Recherche de médecins par nom et prénom
     * Compatible MySQL et PostgreSQL
     */
    public function search(string $query, ?string $type = null): array
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.nom LIKE :query')
            ->orWhere('m.prenom LIKE :query')
            ->orWhere('m.prenom LIKE :query OR m.nom LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('m.dateInscription', 'DESC');

        if ($type) {
            $qb->andWhere('m.typeInscription = :type')
               ->setParameter('type', $type);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Trouver les médecins par type d'inscription
     */
    public function findByType(string $type, ?string $search = null): array
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.typeInscription = :type')
            ->setParameter('type', $type)
            ->orderBy('m.dateInscription', 'DESC');

        if ($search) {
            $qb->andWhere('(m.nom LIKE :query OR m.prenom LIKE :query)')
               ->setParameter('query', '%' . $search . '%');
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Compter par type
     */
    public function countByType(string $type): int
    {
        return $this->createQueryBuilder('m')
            ->select('COUNT(m.id)')
            ->where('m.typeInscription = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getSingleScalarResult();
    }
}

