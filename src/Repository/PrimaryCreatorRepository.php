<?php

namespace App\Repository;

use App\Entity\PrimaryCreator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PrimaryCreator>
 *
 * @method PrimaryCreator|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrimaryCreator|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrimaryCreator[]    findAll()
 * @method PrimaryCreator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrimaryCreatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrimaryCreator::class);
    }

    public function save(PrimaryCreator $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PrimaryCreator $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return PrimaryCreator[] Returns an array of PrimaryCreator objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PrimaryCreator
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    // Search by title or identifier ond order by title
    public function findByValueOrderFirst($value,$order)
    {
        return $this->createQueryBuilder('a')
            ->where('a.first_name like :value or a.last_name like :value')
            ->setParameter('value', '%' . $value . '%')
            ->orderBy('a.first_name', $order)
            ->getQuery()->getResult();
    }

    // Search by title or identifier ond order by identifier
    public function findByValueOrderLast($value,$order)
    {
        return $this->createQueryBuilder('a')
            ->where('a.first_name like :value or a.last_name like :value')
            ->setParameter('value', '%' . $value . '%')
            ->orderBy('a.last_name', $order)
            ->getQuery()->getResult();
    }
}
