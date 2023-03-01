<?php

namespace App\Repository;

use App\Entity\Training;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use App\Model\SearchData;
use Knp\Component\Pager\Pagination\PaginationInterface;


/**
 * @method Training|null find($id, $lockMode = null, $lockVersion = null)
 * @method Training|null findOneBy(array $criteria, array $orderBy = null)
 * @method Training[]    findAll()
 * @method Training[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,
    private PaginatorInterface $paginatorInterface)
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
      *@param int $page
      *@return PaginationInterface
      */
   
      public function findPublished(int $page):PaginationInterface
    {
        $data = $this->createQueryBuilder('t')
            ->andWhere('t.isPublished = :val')
            ->setParameter('val', 1)
            ->orderBy('t.Creatby', 'DESC')
            ->getQuery()
            ->getResult();

        $Training = $this-> paginatorInterface ->paginate ($data,$page,6);
        return $Training;
    }

/**
 * @param int $page
 * @param SearchData $searchData
 * @return PaginationInterface
 */

  
 
    

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


    public function getAllTrainingByDate()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.isPublished = :val')
            ->setParameter('val', 1)
            ->orderBy('t.title', 'ASC')
            ->getQuery()
            ->getResult();
    }


    public function searchTrainings($word)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.title LIKE :val OR c.description LIKE :val')
            ->andWhere('t.isPublished = :publishedVal')
            ->setParameters(array('val' => '%' . $word . '%', 'publishedVal' => 1))
            ->orderBy('t.title', 'ASC')
            ->getQuery()
            ->getResult();
    }


   

}

  
    

