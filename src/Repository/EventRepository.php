<?php

namespace App\Repository;

use DateTime;
use App\Entity\Event;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Event>
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Event $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    private function getPublicQueryBuilder()
    {
        $qb = $this->createQueryBuilder('e');
        $qb->where('e.isBookingAvailable = :isBookingAvailable')
            ->setParameter('isBookingAvailable', true);
        return $qb;
    }

    public function paginateActiveEvent(): Query
    {
        $qb = $this->getPublicQueryBuilder();
        $qb->andWhere('e.endAt > :now')
            ->setParameter('now', new DateTime());
        $qb->orderBy('e.startAt', 'ASC');

        return $qb->getQuery();
    }

    public function paginatePastEvent(): Query
    {
        $qb = $this->getPublicQueryBuilder();
        $qb->andWhere('e.endAt <= :now')
            ->setParameter('now', new DateTime());
        $qb->orderBy('e.endAt', 'DESC');


        return $qb->getQuery();
    }
    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
