<?php

namespace App\Repository;

use App\Entity\RealEstateAd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RealEstateAd>
 *
 * @method RealEstateAd|null find($id, $lockMode = null, $lockVersion = null)
 * @method RealEstateAd|null findOneBy(array $criteria, array $orderBy = null)
 * @method RealEstateAd[]    findAll()
 * @method RealEstateAd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealEstateAdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RealEstateAd::class);
    }

    public function save(RealEstateAd $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RealEstateAd $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RealEstateAd[] Returns an array of RealEstateAd objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RealEstateAd
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
