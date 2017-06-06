<?php
namespace SfCmsProject\CmsBundle\Services;




class HomeAndPost
{

    public function homeAndPost($page, $contentPost, $isHome)
    {

        if($contentPost === "Oui") {
            $page->setContentPost(true);
        }
        else{
            $page->setContentPost(false);
        }
        if($isHome === "Oui") {
            $page->setIsHome(true);
        }
        else{
            $page->setIsHome(false);
        }

        return $page;

    }
}