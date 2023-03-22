<?php

namespace App\Repository;

use App\Entity\ManifestationTransport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ManifestationTransport>
 *
 * @method ManifestationTransport|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManifestationTransport|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManifestationTransport[]    findAll()
 * @method ManifestationTransport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManifestationTransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManifestationTransport::class);
    }

    public function save(ManifestationTransport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ManifestationTransport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ManifestationTransport[] Returns an array of ManifestationTransport objects
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

//    public function findOneBySomeField($value): ?ManifestationTransport
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
