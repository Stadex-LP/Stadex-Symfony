<?php

namespace App\Repository;

use App\Entity\ManifestationMainOeuvre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ManifestationMainOeuvre>
 *
 * @method ManifestationMainOeuvre|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManifestationMainOeuvre|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManifestationMainOeuvre[]    findAll()
 * @method ManifestationMainOeuvre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManifestationMainOeuvreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ManifestationMainOeuvre::class);
    }

    public function save(ManifestationMainOeuvre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ManifestationMainOeuvre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ManifestationMainOeuvre[] Returns an array of ManifestationMainOeuvre objects
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

//    public function findOneBySomeField($value): ?ManifestationMainOeuvre
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
