<?php

namespace App\Repository;

use App\Entity\Categories;
use App\Entity\Status;
use App\Entity\Medias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categories>
 *
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categories::class);
    }

    public function save(Categories $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categories $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getActive(): array
    {
        return $this->createQueryBuilder('c')
        ->join('c.status', 's')
        ->where('s.label = :label')
        ->setParameter('label', 'actif')
        ->getQuery()
        ->getResult();
    }

    //get number of active categories
    public function getActiveCategoryCount()
    {
        $query = $this->createQueryBuilder('c')
        ->select('COUNT(c) as category_count')
        ->leftJoin(Status::class, 's', 'WITH', 'c.status = s.id')
        ->where('s.label = :label')
        ->setParameter('label', 'actif')
        ->getQuery();
    
        $active_category_count = $query->getSingleScalarResult();
        return $active_category_count;
    }

    //get list of categories(name and id) ordered by number of media
    public function getMediaByCategory()
    {
        $query = $this->createQueryBuilder('c')
        ->select('c.id, c.name, s.label, COUNT(m) as media_count')
        ->leftJoin(Medias::class, 'm', 'WITH', 'm.category = c.id')
        ->leftJoin(Status::class, 's', 'WITH', 'c.status = s.id')
        ->groupBy('c.id, c.name, s.label')
        ->orderBy('media_count', 'DESC')
        ->setMaxResults(6)
        ->getQuery();
    
        $media_by_category = $query->getResult();
        return $media_by_category;
    }
}
