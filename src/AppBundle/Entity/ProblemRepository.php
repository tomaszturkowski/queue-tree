<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProblemRepository extends EntityRepository
{
    public function findFirstIn(Project $project)
    {
        $qb = $this->_em->createQueryBuilder();

        $result =  $qb
            ->select('p')
            ->where($qb->expr()->eq('p.project_id', ':projectId'))
            ->setParameter('projectId', $project)
            ->setMaxResults(1)
            ->getFirstResult()
        ;

        dump($result); die('here');
    }
}