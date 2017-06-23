<?php
namespace SfCmsProject\CmsBundle\Services;




class HomeAndPost
{

    public function homeAndPost($page, $isHome)
    {

        if($isHome === "Oui") {
            $page->setIsHome(true);
        }
        else{
            $page->setIsHome(false);
        }

        return $page;

    }
}
