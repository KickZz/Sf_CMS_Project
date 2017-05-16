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


class PageController extends Controller
{
    /**
     * @Route("/cms/admin", name="cms_admin")
     * @return Response
     */

    public function indexAction()
    {

        return $this->render('SfCmsProjectCmsBundle:Admin:index.html.twig');
    }

    /**
     * @param Request $request
     * @Route ("/cms/admin/addpage", name="add_page")
     * @return RedirectResponse|Response
     */
    public function addPageAction(Request $request )
    {

        // Creation d'un nouvel objet page
        $myPage = new Page();
        $form = $this->createForm(PageType::class, $myPage);

        $form->handleRequest($request);
        // Si la requete est en post on valide le formulaire et on hydrate notre BDD
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($myPage);
            $em->flush();

            return $this->redirectToRoute('cms_admin');


        }
        // Si la requête est en ajax on affiche le formulaire
        if ($request->isXmlHttpRequest()) {

            $response = $this->render('SfCmsProjectCmsBundle:Page:formPage.html.twig', array(
            'form' => $form->createView()))->getContent();
                return new Response($response);

            }
            else
            {
                throw new NotFoundHttpException("La page demandée n'existe pas");
            }
    }

    /**
     * @param Request $request
     * @Route ("/cms/admin/viewallpage", name="view_all_page")
     * @return Response
     */
    public function viewAllPage(Request $request){

        // Si la requête est en Ajax on récupère la liste de toutes les pages
        if ($request->isXmlHttpRequest()) {

            // On récupère toutes les pages
            $em = $this->getDoctrine()->getManager();
            $listPage = $em->getRepository('SfCmsProjectCmsBundle:Page')->findAll();

            $response = $this->render('SfCmsProjectCmsBundle:Page:viewAllPage.html.twig', array(
                'listPage' => $listPage
                ))->getContent();

            return new Response($response);

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }

    /**
     * @param Request $request
     * @param Page $page
     * @param $id
     * @return Response
     * @Route ("/cms/admin/editpage/{id}", name="edit_page", requirements={"id": "\d+"})
     */
    public function editPage(Request $request, Page $page, $id){

        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            // on crée un formulaire basé sur cette page
            $form = $this->createForm(PageType::class, $page);

            $response = $this->render('SfCmsProjectCmsBundle:Page:editPage.html.twig', array(
                'id' => $id,
                'form' => $form->createView()))->getContent();

            return new Response($response);

        }

    }

    /**
     * @param Request $request
     * @param Page $page
     * @return Response
     * @internal param $id
     * @Route ("/cms/admin/editpagevalid/{id}", name="edit_page_valid", requirements={"id": "\d+"})
     */
    public function editPageValid(Request $request, Page $page){

        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $nameNew = $request->get('name');
            $contentNew = $request->get('content');
            $descriptionNew = $request->get('description');
            $contentArticleNew = $request->get('contentArticle');
            $isHomeNew = $request->get('isHome');


            $page->setName($nameNew);
            $page->setContent($contentNew);
            $page->setdescription($descriptionNew);
            $page->setContentArticle($contentArticleNew);
            $page->setIsHome($isHomeNew);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            // On récupère toutes les pages
            $em = $this->getDoctrine()->getManager();
            $listPage = $em->getRepository('SfCmsProjectCmsBundle:Page')->findAll();

            $response = $this->render('SfCmsProjectCmsBundle:Page:viewAllPage.html.twig', array(
                'listPage' => $listPage
            ))->getContent();

            return new Response($response);

        }

    }

    /**
     * @param Request $request
     * @param Page $page
     * @return Response
     * @Route ("/cms/admin/suppagevalid/{id}", name="sup_page_valid", requirements={"id": "\d+"})
     */
    public function supPageValid(Request $request, Page $page){

        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');

            if ($this->isCsrfTokenValid('csrf_sup_page', $token)) {

                $em = $this->getDoctrine()->getManager();
                $em->remove($page);
                $em->flush();

            }

            // On récupère toutes les pages
            $em = $this->getDoctrine()->getManager();
            $listPage = $em->getRepository('SfCmsProjectCmsBundle:Page')->findAll();

            $response = $this->render('SfCmsProjectCmsBundle:Page:viewAllPage.html.twig', array(
                'listPage' => $listPage
            ))->getContent();

            return new Response($response);

        }

    }



}
