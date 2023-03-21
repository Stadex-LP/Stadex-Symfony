<?php

namespace App\Repository;

use App\Entity\ManifestationMateriel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ManifestationMateriel>
 *
 * @method ManifestationMateriel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManifestationMateriel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManifestationMateriel[]    findAll()
 * @method ManifestationMateriel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManifestationMaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManifestationMateriel::class);
    }

    public function save(ManifestationMateriel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ManifestationMateriel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ManifestationMateriel[] Returns an array of ManifestationMateriel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ManifestationMateriel
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
