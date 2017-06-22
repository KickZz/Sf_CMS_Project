<?php
namespace SfCmsProject\CmsBundle\Services;


class CreateTemplateFile
{
    /**
     * @param $name
     * @param $content
     */
    public function createTemplateFile($name,$content)
    {
        $titre = str_replace(' ','-',$name);
        $createDir = __DIR__;
        $file = fopen($createDir.'../../Resources/views/Template/Custom/'.$titre.'.html.twig',"a+" );
        fwrite($file,$content);
        fclose($file);

    }

}
