<?php

namespace SfCmsProject\CmsBundle\Repository;


use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAll()
    {
        $qb = $this->createQueryBuilder('post');
        $qb
            ->where('post.suppress = false');
        return $qb->getQuery();
    }
    public function getPosts($page, $nbParPage)
    {
        $query = $this->createQueryBuilder('post')
            ->orderBy('post.dateCreated', 'DESC')
            ->where('post.suppress = false')
            ->getQuery()
        ;

        $query
            // On définit l'article à partir de laquelle commencer la liste
            ->setFirstResult(($page-1) * $nbParPage)
            // Ainsi que le nombre d'article à afficher sur une page
            ->setMaxResults($nbParPage)
        ;

        // Enfin, on retourne l'objet Paginator correspondant à la requête construite
        return new Paginator($query, true);
    }

}
