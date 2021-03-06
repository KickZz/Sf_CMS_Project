<?php

namespace SfCmsProject\CmsBundle\Repository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends \Doctrine\ORM\EntityRepository
{

    public function findAllPageByOrderMenu()
    {
        $qb = $this->createQueryBuilder('page');
        $qb ->orderBy('page.orderMenu')
        ;
        return $qb->getQuery()->getResult();
    }
    public function findAllSubPageOfThisPage($id)
    {
        $qb = $this->createQueryBuilder('page');
        $qb ->where('page.idSubMenu = :id')
            ->setParameter('id', $id)
        ;
        return $qb->getQuery()->getResult();
    }
    public function getAll()
    {
        $qb = $this->createQueryBuilder('page');
        $qb
            ->where('page.disabled = false');
        return $qb->getQuery();
    }

}
