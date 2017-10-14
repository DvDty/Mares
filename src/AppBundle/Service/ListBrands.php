<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

class ListBrands
{
    private $em;

    private $brands;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getBrands()
    {
        $repo = $this->em->getRepository('AppBundle:Brand');

        $brands = $repo->createQueryBuilder('c')
            ->select("c")
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();

        $this->brands = $brands;

        return $this->brands;
    }
}