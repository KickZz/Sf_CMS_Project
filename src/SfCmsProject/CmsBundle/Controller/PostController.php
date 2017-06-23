<?php

namespace SfCmsProject\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SfCmsProject\CmsBundle\Entity\Post;
use SfCmsProject\CmsBundle\Form\Type\PostType;
use SfCmsProject\CmsBundle\Form\Type\AddPostType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class PostController extends Controller
{
    /**
     * @param Request $request
     * @Route ("/cms/admin/addppost", name="add_post")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function addPostAction(Request $request )
    {


        // Si la requête est en ajax on affiche le formulaire
        if ($request->isXmlHttpRequest()) {

            // Creation d'un nouvel objet post
            $page = new Post();
            $form = $this->createForm(AddPostType::class, $page);


            $response = $this->render('SfCmsProjectCmsBundle:Post:formPost.html.twig', array(
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
     * @Route ("/cms/admin/addpostvalid", name="add_post_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function addPostValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $post = New Post();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            $post->setName($request->get('name'));
            $post->setContent($request->get('content'));
            $em->persist($post);
            $em->flush();

            // On récupère toutes les posts
            $listPost = $em->getRepository('SfCmsProjectCmsBundle:Post')->findAll();

            $response = $this->render('SfCmsProjectCmsBundle:Post:viewAllPost.html.twig', array(
                'listPost' => $listPost
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
     * @Route ("/cms/admin/viewallpost", name="view_all_post")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function viewAllPostAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax on récupère la liste de toutes les posts
        if ($request->isXmlHttpRequest()) {

            // On récupère toutes les pages
            $listPost = $em->getRepository('SfCmsProjectCmsBundle:Post')->findAll();

            $response = $this->render('SfCmsProjectCmsBundle:Post:viewAllPost.html.twig', array(
                'listPost' => $listPost
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
     * @param Post $post
     * @param $id
     * @return Response
     * @Route ("/cms/admin/editpost/{id}", name="edit_post", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function editPostAction(Request $request, Post $post, $id){

        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            // on crée un formulaire basé sur cette page
            $form = $this->createForm(PostType::class, $post);


            $response = $this->render('SfCmsProjectCmsBundle:Post:editPost.html.twig', array(
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
     * @param Post $post
     * @return Response
     * @internal param $id
     * @Route ("/cms/admin/editpostvalid/{id}", name="edit_post_valid", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function editPageValidAction(Request $request, Post $post){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $post->setName($request->get('name'));
            $post->setContent($request->get('content'));
            $em->flush();

            // On récupère toutes les posts
            $listPost = $em->getRepository('SfCmsProjectCmsBundle:Post')->findAll();

            $response = $this->render('SfCmsProjectCmsBundle:Post:viewAllPost.html.twig', array(
                'listPost' => $listPost
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
     * @param Post $post
     * @return Response
     * @Route ("/cms/admin/suppostvalid/{id}", name="sup_post_valid", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function supPostValidAction(Request $request, Post $post){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');

            if ($this->isCsrfTokenValid('csrf_sup_post', $token)) {

                $em->remove($post);
                $em->flush();

            }

            // On récupère toutes les posts
            $listPost = $em->getRepository('SfCmsProjectCmsBundle:Post')->findAll();

            $response = $this->render('SfCmsProjectCmsBundle:Post:viewAllPost.html.twig', array(
                'listPost' => $listPost
            ))->getContent();

            return new Response($response);

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }
}
