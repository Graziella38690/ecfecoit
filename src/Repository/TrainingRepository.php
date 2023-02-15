<?php

namespace App\Repository;

use App\Entity\Training;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use App\Model\SearchData;

/**
 * @method Training|null find($id, $lockMode = null, $lockVersion = null)
 * @method Training|null findOneBy(array $criteria, array $orderBy = null)
 * @method Training[]    findAll()
 * @method Training[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Training::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Training $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Training $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
      * @return Training[] Returns an array of Training objects
      */
   
      public function findPublished()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.isPublished = :val')
            ->setParameter('val', 1)
            ->orderBy('t.Creatby', 'DESC')
            
            ->getQuery()
            ->getResult();
    }



      public function findLastTraining()
      {
          return $this->createQueryBuilder('t')

              ->orderBy('t.Datecreate', 'DESC')
              ->setMaxResults(3)
              ->getQuery()
              ->getResult()
          ;
      }






     /**
      * @return Training[] Returns an array of Training objects
     */
    
    public function findByUser($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }




   /* public function findBySearch(SearchData $SearchData): PaginationInterface
    {
        $data = $this ->createQueryBuilder('t')
        ->Where('t.state LIKE :state')
        ->setParameters('state','%STATE_PUBLISHED%');

        if(!empty($SearchData->q)){
            $data = $data
            ->andWhere('t.title LIKE :q')
            ->setParameter('t',"%{$SearchData ->q}%");
        }
        $data = $data
                 ->getQuery()
                ->getResult();

$Training = $this->paginatorInterface->paginate ($data, $SearchData ->page,9);
return $Training;
}
 */

}

  
    /*
    public function findOneBySomeField($value): ?Training
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

