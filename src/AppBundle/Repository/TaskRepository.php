<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function findByAuthorField($author)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.author = :author')
            ->setParameter('author', $author)
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->useResultCache(true, 3600, 'tasks_all')
            ->getResult();
    }

    public function findByAnonyme()
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.author IS NULL')
            ->orderBy('t.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->useResultCache(true, 3600, 'tasks_all')
            ->getResult();
    }
}
