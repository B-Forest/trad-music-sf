<?php

namespace App\Repository;

use App\Entity\Gig;
use App\Entity\Musician;
use App\Entity\Pub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Gig>
 *
 * @method Gig|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gig|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gig[]    findAll()
 * @method Gig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gig::class);
    }

    public function save(Gig $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Gig $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findFutureGig(Pub|Musician $entity = null, int $limit = 4  ): array
    {
        $qb = $this->createQueryBuilder('gig');

        $qb->addSelect('pub')
            ->join('gig.pub', 'pub')
            ->where('gig.dateStart > :today');

        if ($entity instanceof Pub) {
            $qb->andWhere('pub.id = :pub_id')
            ->setParameter(':pub_id', $entity->getId());
        }
        elseif ($entity instanceof Musician) {
            $qb->join('gig.participants', 'participants')
                ->andWhere('pub.id = :musician_id')
                ->setParameter(':musician_id', $entity->getId());
        }

        $qb->orderBy('gig.dateStart', 'ASC')
            ->setMaxResults($limit)
            ->setParameter(':today', new \DateTime());

        //SELECT * FROM gig WHERE date_start > NOW() ORDER BY date-start ASC LIMIT 4
        return  $qb->getQuery()->getResult();
    }

    public function findPastGig(Pub|Musician $entity = null, int $limit = 4  ): array
    {
        $qb = $this->createQueryBuilder('gig');

        $qb->addSelect('pub')
            ->join('gig.pub', 'pub')
            ->where('gig.dateStart < :today');

        if ($entity instanceof Pub) {
            $qb->andWhere('pub.id = :id')
                ->setParameter(':id', $entity->getId());
        }
        elseif ($entity instanceof Musician) {
            $qb->join('gig.participants', 'participants')
                ->andWhere('pub.id = :musician_id')
                ->setParameter(':musician_id', $entity->getId());
        }

        $qb->orderBy('gig.dateStart', 'DESC')
            ->setMaxResults($limit)
            ->setParameter(':today', new \DateTime());

        //SELECT * FROM gig WHERE date_start > NOW() ORDER BY date-start ASC LIMIT 4
        return  $qb->getQuery()->getResult();
    }

//    /**
//     * @return Gig[] Returns an array of Gig objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Gig
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
