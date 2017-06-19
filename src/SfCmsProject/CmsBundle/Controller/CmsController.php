<?php

namespace SfCmsProject\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CmsController extends Controller
{
    /**
     * @param Request $request
     * @Route("/{slug}", name="homepage")
     * @return Response
     * @Method({"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('SfCmsProjectCmsBundle:CMS:index.html.twig');
    }

    /**
     * @Route("/viewnavbar", name="view_navbar")
     * @return Response
     */
    public function viewNavBarAction()
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère toutes les pages
        $listPage = $em->getRepository('SfCmsProjectCmsBundle:Page')->findAllPageByOrderMenu();

        return $this->render('SfCmsProjectCmsBundle:CMS:navbar.html.twig', array(
            'listPage' => $listPage,
        ));

    }
}
