<?php

namespace SfCmsProject\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SfCmsProject\CmsBundle\Entity\Page;
use SfCmsProject\CmsBundle\Form\PageType;
//use SfCmsProject\CmsBundle\Entity\Post;
//use SfCmsProject\CmsBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/cms/admin", name="sf_cms_project_cms_admin")
     * @return Response
     */

    public function indexAction()
    {

        return $this->render('SfCmsProjectCmsBundle:Admin:index.html.twig');
    }

    /**
     * @param Request $request
     * @Route ("/cms/admin/addpage", name="sf_cms_project_cms_admin_add_page")
     * @return RedirectResponse|Response
     */
    public function addPageAction(Request $request )
    {

        // Creation d'un nouvel objet page
        $myPage = new Page();
        $form = $this->createForm(PageType::class, $myPage);

        // Si la requete est en post on valide le formulaire et on hydrate notre BDD
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($myPage);
            $em->flush();

            return $this->redirectToRoute('sf_cms_project_cms_admin');


        }
        // Si la requête est en ajax on affiche le formulaire
        if ($request->isXmlHttpRequest()) {

            $reponse = $this->render('SfCmsProjectCmsBundle:Admin:formPage.html.twig', array(
            'form' => $form->createView()))->getContent();
                return new Response($reponse);

            }
            else
            {
                throw new NotFoundHttpException("La page demandée n'existe pas");
            }
    }

    /**
     * @param Request $request
     * @Route ("/cms/admin/viewallpage", name="sf_cms_project_cms_admin_view_all_page")
     * @return Response
     */
    public function viewAllPage(Request $request){

        // Si la requête est en Ajax on récupère la liste de toutes les pages
        if ($request->isXmlHttpRequest()) {

            // On récupère toutes les pages
            $em = $this->getDoctrine()->getManager();
            $listPage = $em->getRepository('SfCmsProjectCmsBundle:Page')->findAll();

            $reponse = $this->render('SfCmsProjectCmsBundle:Admin:viewAllPage.html.twig', array(
                'listPage' => $listPage
                ))->getContent();

            return new Response($reponse);

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }


}
