<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comments>
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    //    /**
    //     * @return Comments[] Returns an array of Comments objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Comments
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getPaginateComments($id, $page, $limit)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.isActiveCom = 1')
            ->andWhere('a.tricks = :id') // Correction : Vérification sur "tricks" au lieu de "users"
            ->setParameter(':id', $id)
            ->orderBy('a.dateCreateCom', 'DESC')
            ->getQuery();
    
        // Utilisation de Doctrine Paginator
        $paginator = new Paginator($query);
    
        // Configuration de la pagination
        $paginator->getQuery()
            ->setFirstResult(($page - 1) * $limit) // Début de la page
            ->setMaxResults($limit);              // Limite par page
    
        return $paginator;
    }
}
