<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function findFirst()
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb
            ->select('p')
            ->from('AppBundle:Project', 'p')
            ->orderBy('p.value', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return $result[0];
    }
}