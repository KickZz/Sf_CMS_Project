<?php
namespace SfCmsProject\CmsBundle\Services;



class ContentPost
{

    public function contentPost($page, $contentPost)
    {

        if($contentPost === 'true') {
            $page->setContentPost(true);

        }
        else{
            $page->setContentPost(false);
        }

        return $page;

    }
}
