<?php

namespace SfCmsProject\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CmsController extends Controller
{
    /**
     * @Route("/", name="pre_homepage")
     * @return Response
     * @Method({"GET"})
     */
    public function preIndexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('SfCmsProjectCmsBundle:Page')->findOneBy(array('isHome'=> true));
        if ( $page !== null) {
            $slug = $page->getName();
            return $this->redirectToRoute('homepage', array(
                'slug' => $slug
            ));
        }
        else{

            return $this->redirectToRoute('cms_admin');
        }
    }
    /**
     * @param Request $request
     * @Route("/{slug}", name="homepage")
     * @return Response
     * @Method({"GET"})
     */
    public function indexAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('SfCmsProjectCmsBundle:Page')->findOneBy(array('name'=> $slug));

        if ( $page->getTemplate() !== null) {
            if ( $page->getContentPost() === true){
                return $this->redirectToRoute('page_with_post', array(
                    'slug'=> $slug,
                    'nbPage' => 1
                ));
            }
            $template = $page->getTemplate();
            return $this->render('SfCmsProjectCmsBundle:CMS:index.html.twig', array(
                'template' => $template,
                'page' => $page));
        }
        else{
            return $this->render('SfCmsProjectCmsBundle:CMS:indexWithoutTemplate.html.twig', array(
                'page' => $page));
        }
    }
    /**
     * @param Request $request
     * @Route("/{slug}/{nbPage}", name="page_with_post", requirements={"nbPage": "\d+"} )
     * @return Response
     * @Method({"GET"})
     */
    public function pageWithPostAction(Request $request, $slug, $nbPage)
    {
        $em = $this->getDoctrine()->getManager();

        if ($nbPage < 1) {
            throw new NotFoundHttpException('Page "'.$nbPage.'" inexistante.');
        }
        $nbParPage = 3;

        // On récupère notre objet Paginator
        $listPost = $this->getDoctrine()
            ->getManager()
            ->getRepository('SfCmsProjectCmsBundle:Post')
            ->getPosts($nbPage, $nbParPage)
        ;

        // On calcule le nombre total de pages grâce au count
        $nbPages = ceil(count($listPost) / $nbParPage);

        // Si la page n'existe pas, on retourne une 404
        if ($nbPage > $nbPages) {
            throw $this->createNotFoundException("La page ".$nbPage." n'existe pas.");
        }

        $page = $em->getRepository('SfCmsProjectCmsBundle:Page')->findOneBy(array('name'=> $slug));

        $template = $page->getTemplate();
        return $this->render('SfCmsProjectCmsBundle:CMS:index.html.twig',array(
            'template'=> $template,
            'nbPages'     => $nbPages,
            'nbPage'        => $nbPage,
            'page' => $page,
            'listPost' => $listPost));

    }
    /**
     * @param Request $request
     * @Route("/view/post/{slug}", name="view_one_post")
     * @return Response
     * @Method({"GET"})
     */
    public function viewOnePostAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('SfCmsProjectCmsBundle:Post')->findOneBy(array('name'=> $slug));
        if ( $post->getTemplate() !== null) {
            $template = $post->getTemplate();
            return $this->render('SfCmsProjectCmsBundle:CMS:indexPost.html.twig', array(
                'template' => $template,
                'post' => $post));
        }
        else{
            return $this->render('SfCmsProjectCmsBundle:CMS:indexPostWithoutTemplate.html.twig', array(
                'post' => $post));
        }
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
