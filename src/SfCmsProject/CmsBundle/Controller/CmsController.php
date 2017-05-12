<?php

namespace SfCmsProject\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CmsController extends Controller
{
    /**
     * @param Request $request
     * @Route("/{slug}", name="sf_cms_project_cms_homepage")
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('SfCmsProjectCmsBundle:CMS:index.html.twig');
    }
}
