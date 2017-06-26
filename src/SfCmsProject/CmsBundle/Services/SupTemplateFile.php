<?php
namespace SfCmsProject\CmsBundle\Services;


class SupTemplateFile
{
    /**
     * @param $name
     */
    public function supTemplateFile($name)
    {

        $supDir = __DIR__;
        unlink($supDir.'../../Resources/views/Template/Custom/'.$name.'.html.twig');

    }
    /**
     * @param $name
     */
    public function supTemplatePostFile($name)
    {

        $supDir = __DIR__;
        unlink($supDir.'../../Resources/views/Template/CustomPost/'.$name.'.html.twig');

    }

}