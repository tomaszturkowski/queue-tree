<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    public function findFirst()
    {
        return $this
            ->_em
            ->createQuery('SELECT p FROM AppBundle:Project LIMIT 1')
            ->getSingleResult()
        ;
    }
}