<?php
namespace SfCmsProject\CmsBundle\Services;

use Doctrine\ORM\EntityManagerInterface;


class CountSubPage
{
    private $em;

    /**
     * CountSubPage constructor.
     * @param EntityManagerInterface $em
     */

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function countSubPage()
    {
        $listPage = $this->em->getRepository('SfCmsProjectCmsBundle:Page')->findAllPageByOrderMenu();

        foreach ($listPage as $page){

            $subPage = count($this->em->getRepository('SfCmsProjectCmsBundle:Page')->findAllSubPageOfThisPage($page->getId()));
            if ( $subPage > 0){
                $page->setHaveSubPage(true);
                $page->setNumberSubPage($subPage);
            }
            else if ($subPage === 0){
                $page->setHaveSubPage(false);
                $page->setNumberSubPage(0);
            }
            $this->em->flush();
        }

    }

}
