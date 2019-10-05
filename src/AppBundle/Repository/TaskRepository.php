<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function findByAuthorField($author)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.author = :author')
            ->setParameter('author', $author)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->useResultCache(true, 10, 'tasks_all')
            ->getResult();
    }
}
