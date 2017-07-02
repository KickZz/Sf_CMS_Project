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
     * @Route ("/cms/admin/security/addppost", name="add_post")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function addPostAction(Request $request )
    {

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en ajax on affiche le formulaire
        if ($request->isXmlHttpRequest()) {

            // Creation d'un nouvel objet post
            $post = new Post();
            $form = $this->createForm(AddPostType::class, $post);

            // Permet de creer le tableau contenant la liste de lien dans tinymce
            $query = $em->getRepository('SfCmsProjectCmsBundle:Post')->getAll();
            $list = $query->getArrayResult();
            $listPost = array();
            foreach ($list as $value)
            {
                $arrayTmp = array('title' => $value['name'] , 'value' => '/post/'.$value['name']);
                $listPost[] = $arrayTmp;
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
            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Post:formPost.html.twig', array(
                'listImage' => json_encode($listImage, JSON_UNESCAPED_UNICODE),
                'listPost' => json_encode($listPost, JSON_UNESCAPED_UNICODE),
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
     * @Route ("/cms/admin/security/addpostvalid", name="add_post_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function addPostValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $post = New Post();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');

            if ($this->isCsrfTokenValid('csrf_add_post', $token)) {

                $post->setName($request->get('name'));
                $post->setContent($request->get('content'));
                if ($request->get('template') !== 'nothing') {
                    $template = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findOneBy(array('name' => $request->get('template')));
                    $post->setTemplate($template);
                }
                $post->setAuthor($user->getSignature());
                $em->persist($post);
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
    /**
     * @param Request $request
     * @Route ("/cms/admin/security/viewallpost", name="view_all_post")
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
     * @Route ("/cms/admin/security/editpost/{id}", name="edit_post", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function editPostAction(Request $request, Post $post, $id){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            // on crée un formulaire basé sur cette page
            $form = $this->createForm(PostType::class, $post);

            // Permet de creer le tableau contenant la liste de lien dans tinymce
            $query = $em->getRepository('SfCmsProjectCmsBundle:Post')->getAll();
            $list = $query->getArrayResult();
            $listPost = array();
            foreach ($list as $value)
            {
                $arrayTmp = array('title' => $value['name'] , 'value' => '/post/'.$value['name']);
                $listPost[] = $arrayTmp;
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
            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Post:editPost.html.twig', array(
                'listPost' => json_encode($listPost, JSON_UNESCAPED_UNICODE),
                'listImage' => json_encode($listImage, JSON_UNESCAPED_UNICODE),
                'listTemplate'=>$listTemplate,
                'post'=>$post,
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
     * @Route ("/cms/admin/security/editpostvalid/{id}", name="edit_post_valid", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function editPostValidAction(Request $request, Post $post){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');

            if ($this->isCsrfTokenValid('csrf_edit_post', $token)) {

                $post->setName($request->get('name'));
                $post->setContent($request->get('content'));
                $post->setDateEdit(new \Datetime('now', new \DateTimeZone('Europe/Paris')));
                if ($request->get('template') !== 'nothing') {
                    $template = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findOneBy(array('name' => $request->get('template')));
                    $post->setTemplate($template);
                }
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

    /**
     * @param Request $request
     * @param Post $post
     * @return Response
     * @Route ("/cms/admin/security/suppostvalid/{id}", name="sup_post_valid", requirements={"id": "\d+"})
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
