<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function findFirst()
    {
        return $this
            ->_em
            ->createQueryBuilder()
            ->select()
            ->setMaxResults(1)
            ->getFirstResult()
        ;
    }
}