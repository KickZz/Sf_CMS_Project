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
     * @param Request $request
     * @Route("/cms/admin/security", name="cms_admin")
     * @Method({"GET"})
     * @return Response
     */

    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('SfCmsProjectCmsBundle:Page')->findOneBy(array('isHome'=> true));
        // On test l'existence d'une page d'accueil
        if ( $page === null ){
            $request->getSession()->getFlashBag()->add('notice', 'Veuillez choisir une page d\'accueil');
        }
        return $this->render('SfCmsProjectCmsBundle:Admin:index.html.twig',array(
            'page' => $page));
    }

    /**
     * @param Request $request
     * @Route ("/cms/admin/security/addpage", name="add_page")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function addPageAction(Request $request )
    {

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en ajax on affiche le formulaire
        if ($request->isXmlHttpRequest()) {

            // Creation d'un nouvel objet page
            $page = new Page();
            $form = $this->createForm(AddPageType::class, $page);

            // Permet de creer le tableau contenant la liste de lien dans tinymce
            $query = $em->getRepository('SfCmsProjectCmsBundle:Page')->getAll();
            $list = $query->getArrayResult();
            $listPage = array();
            foreach ($list as $page)
            {
                $arrayTmp = array('title' => $page['name'] , 'value' => '/'.$page['name']);
                $listPage[] = $arrayTmp;
            }
            // Permet de creer le tableau contenant la liste des images dans tinymce
            $query = $em->getRepository('SfCmsProjectCmsBundle:Image')->getAll();
            $list = $query->getArrayResult();
            $listImage = array();
            foreach ($list as $value)
            {
                $arrayTmp = array('title' => $value['title'] , 'value' => '../../../web/uploads/img/'.$value['url']);
                $listImage[] = $arrayTmp;
            }
            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:Template')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Page:formPage.html.twig', array(
                'listImage' => json_encode($listImage, JSON_UNESCAPED_UNICODE),
                'listPage' => json_encode($listPage, JSON_UNESCAPED_UNICODE),
                'listTemplate'=>$listTemplate,
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
     * @Route ("/cms/admin/security/viewallpage", name="view_all_page")
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
     * @Route ("/cms/admin/security/editpage/{id}", name="edit_page", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function editPageAction(Request $request, Page $page, $id){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            // on crée un formulaire basé sur cette page
            $form = $this->createForm(PageType::class, $page);
            // Permet de creer le tableau contenant la liste de lien dans tinymce
            $query = $em->getRepository('SfCmsProjectCmsBundle:Page')->getAll();
            $list = $query->getArrayResult();
            $listPage = array();
            foreach ($list as $value)
            {
                $arrayTmp = array('title' => $value['name'] , 'value' => '/'.$value['name']);
                $listPage[] = $arrayTmp;
            }
            // Permet de creer le tableau contenant la liste des images dans tinymce
            $query = $em->getRepository('SfCmsProjectCmsBundle:Image')->getAll();
            $list = $query->getArrayResult();
            $listImage = array();
            foreach ($list as $value)
            {
                $arrayTmp = array('title' => $value['title'] , 'value' => '../../../web/uploads/img/'.$value['url']);
                $listImage[] = $arrayTmp;
            }
            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:Template')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Page:editPage.html.twig', array(
                'listImage' => json_encode($listImage, JSON_UNESCAPED_UNICODE),
                'listPage' => json_encode($listPage, JSON_UNESCAPED_UNICODE),
                'listTemplate'=>$listTemplate,
                'page'=>$page,
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
     * @Route ("/cms/admin/security/editpagevalid/{id}", name="edit_page_valid", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function editPageValidAction(Request $request, Page $page){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');
            // Verification du jeton csrf
            if ($this->isCsrfTokenValid('csrf_edit_page', $token)) {

                $page->setName($request->get('name'));
                $page->setContent($request->get('content'));
                $page->setDescription($request->get('description'));

                $page = $this->container->get('sf_cms_project_cms.ContentPost')->contentPost($page, $request->get('contentPost'));

                if ($request->get('template') !== 'nothing'){
                    $template = $em->getRepository('SfCmsProjectCmsBundle:Template')->findOneBy(array('name'=>$request->get('template')));
                    $page->setTemplate($template);
                }

                $page = $this->container->get('sf_cms_project_cms.Home')->home($page, $request->get('isHome'));

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

    /**
 * @param Request $request
 * @Route ("/cms/admin/security/addpagevalid", name="add_page_valid")
 * @Method({"GET","POST"})
 * @return Response
 */
    public function addPageValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $page = New Page();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');

            if ($this->isCsrfTokenValid('csrf_add_page', $token)) {

                $page->setName($request->get('name'));
                $page->setContent($request->get('content'));
                $page->setDescription($request->get('description'));
                $page->setContentPost($request->get('contentPost'));
                $page = $this->container->get('sf_cms_project_cms.ContentPost')->contentPost($page, $request->get('contentPost'));
                if ($request->get('template') !== 'nothing'){
                    $template = $em->getRepository('SfCmsProjectCmsBundle:Template')->findOneBy(array('name'=>$request->get('template')));
                    $page->setTemplate($template);
                }
                $page = $this->container->get('sf_cms_project_cms.Home')->home($page, $request->get('isHome'));


                $em->persist($page);
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

    /**
     * @param Request $request
     * @param Page $page
     * @return Response
     * @Route ("/cms/admin/security/suppagevalid/{id}", name="sup_page_valid", requirements={"id": "\d+"})
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
