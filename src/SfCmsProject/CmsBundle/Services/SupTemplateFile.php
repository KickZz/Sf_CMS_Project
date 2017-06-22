<?php
namespace SfCmsProject\CmsBundle\Services;


class SupTemplateFile
{
    /**
     * @param $name
     * @param $content
     */
    public function supTemplateFile($name)
    {

        $supDir = __DIR__;
        unlink($supDir.'../../Resources/views/Template/Custom/'.$name.'.html.twig');

    }

}