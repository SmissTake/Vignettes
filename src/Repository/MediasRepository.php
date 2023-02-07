<?php

namespace App\Repository;

use App\Entity\Medias;
use App\Entity\Status;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Medias>
 *
 * @method Medias|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medias|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medias[]    findAll()
 * @method Medias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medias::class);
    }

    public function save(Medias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Medias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getActive(): array
    {
        return $this->createQueryBuilder('m')
            ->join('m.status', 's')
            ->where('s.label = :label')
            ->setParameter('label', 'actif')
            ->getQuery()
            ->getResult();
    }

    //get active media by user
    public function getActiveByUser(int $id)
    {
        $query = $this->createQueryBuilder('m')
            ->join('m.status', 's')
            ->where('s.label = :label')
            ->andWhere('m.user = :id')
            ->setParameter('label', 'actif')
            ->setParameter('id', $id)
            ->getQuery();
    
        $media_by_user = $query->getResult();
        return $media_by_user;
    }
}
