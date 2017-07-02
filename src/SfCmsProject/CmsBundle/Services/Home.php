<?php
namespace SfCmsProject\CmsBundle\Services;

use Doctrine\ORM\EntityManagerInterface;


class Home
{

    private $em;

    /**
     * Home constructor.
     * @param EntityManagerInterface $em
     */

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function home($page, $isHome)
    {

        if($isHome === 'true') {
            // On remet a false les isHome de toutes les pages
            $listPage = $this->em->getRepository('SfCmsProjectCmsBundle:Page')->findAll();
            foreach ($listPage as $value){
                $value->setIsHome(false);
            }
            // Et on attribut la page d'accueil à la page courante
            $page->setIsHome(true);

        }
        else{
            $page->setIsHome(false);
        }

        return $page;

    }
}
