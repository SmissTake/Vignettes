<?php

namespace App\Repository;

use App\Entity\Users;
use App\Entity\Medias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Users>
 *
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function save(Users $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Users $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //get list of user(mail and id) ordered by number of media
    public function getMediaByUser()
    {
        $query = $this->createQueryBuilder('u')
        ->select('u.id, u.email, COUNT(m) as media_count')
        ->leftJoin(Medias::class, 'm', 'WITH', 'm.user = u.id')
        ->groupBy('u.id, u.email')
        ->orderBy('media_count', 'DESC')
        ->setMaxResults(6)
        ->getQuery();
    
        $media_by_user = $query->getResult();
        return $media_by_user;
    }
}
