<?php

namespace App\Repository;

use App\Entity\Mission;
use App\Services\SearchFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mission>
 *
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    public function add(Mission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Mission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Mission[] Returns an array of Mission objects
     */
    public function findByFilter(SearchFilter $searchFilter)
    {
        $query = $this->createQueryBuilder('m')
            ->select('m,s')
            ->join('m.status','s');

            if (!empty($searchFilter->cherche)){
                $query = $query
                    ->Where('m.code= :cherche')
                    ->setParameter('cherche', $searchFilter->cherche);
            }
            if (!empty($searchFilter->status)){
                $query = $query
                    ->andWhere('m.status IN (:status)')
                    ->setParameter('status', $searchFilter->status);
            }


           return $query->getQuery()->getResult()

        ;
    }

//    public function findOneBySomeField($value): ?Mission
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
