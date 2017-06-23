<?php

namespace SfCmsProject\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SfCmsProject\CmsBundle\Entity\Page;
use SfCmsProject\CmsBundle\Form\Type\PageType;
use SfCmsProject\CmsBundle\Form\Type\AddPageType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class PageController extends Controller
{
    /**
     * @Route("/cms/admin", name="cms_admin")
     * @Method({"GET"})
     * @return Response
     */

    public function indexAction()
    {

        return $this->render('SfCmsProjectCmsBundle:Admin:index.html.twig');
    }

    /**
     * @param Request $request
     * @Route ("/cms/admin/addpage", name="add_page")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function addPageAction(Request $request )
    {


        // Si la requête est en ajax on affiche le formulaire
        if ($request->isXmlHttpRequest()) {

            // Creation d'un nouvel objet page
            $page = new Page();
            $form = $this->createForm(AddPageType::class, $page);


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
     * @Method({"GET","POST"})
     * @return Response
     */
    public function viewAllPageAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax on récupère la liste de toutes les pages
        if ($request->isXmlHttpRequest()) {

            // On récupère toutes les pages
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
     * @Method({"GET","POST"})
     */
    public function editPageAction(Request $request, Page $page, $id){

        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            // on crée un formulaire basé sur cette page
            $form = $this->createForm(PageType::class, $page);


            $response = $this->render('SfCmsProjectCmsBundle:Page:editPage.html.twig', array(
                'id' => $id,
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
     * @param Page $page
     * @return Response
     * @internal param $id
     * @Route ("/cms/admin/editpagevalid/{id}", name="edit_page_valid", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function editPageValidAction(Request $request, Page $page){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $page->setName($request->get('name'));
            $page->setContent($request->get('content'));
            $page->setDescription($request->get('description'));
            $isHome = $request->get('isHome');

            $this->container->get('sf_cms_project_cms.HomeAndPost')->homeAndPost($page, $isHome);

            $em->flush();

            // On récupère toutes les pages
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
 * @Route ("/cms/admin/addpagevalid", name="add_page_valid")
 * @Method({"GET","POST"})
 * @return Response
 */
    public function addPageValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $page = New Page();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            $page->setName($request->get('name'));
            $page->setContent($request->get('content'));
            $page->setDescription($request->get('description'));
            $isHome = $request->get('isHome');

            $this->container->get('sf_cms_project_cms.HomeAndPost')->homeAndPost($page, $isHome);


            $em->persist($page);
            $em->flush();

            // On récupère toutes les pages
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
     * @return Response
     * @Route ("/cms/admin/suppagevalid/{id}", name="sup_page_valid", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function supPageValidAction(Request $request, Page $page){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');

            if ($this->isCsrfTokenValid('csrf_sup_page', $token)) {

                // On vérifie si la page à des sous-page et si oui on les remets dans la liste des pages restante
                if($page->getHaveSubPage() === true){
                    $listSubPage = $em->getRepository('SfCmsProjectCmsBundle:Page')->findBy(array ('idSubMenu' => $page->getId()));
                    foreach ($listSubPage as $subPage ){
                        $subPage->setInsideMenu(false);
                        $subPage->setInsideSubMenu(false);
                        $subPage->setIdSubMenu(0);
                        $subPage->setOrderMenu(10000);
                        $em->flush();
                    }
                }
                $em->remove($page);
                $em->flush();

            }

            // On récupère toutes les pages
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



}
