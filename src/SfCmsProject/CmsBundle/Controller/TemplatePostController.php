<?php

namespace SfCmsProject\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SfCmsProject\CmsBundle\Entity\TemplatePost;
use SfCmsProject\CmsBundle\Form\Type\AddTemplatePostType;
use SfCmsProject\CmsBundle\Form\Type\EditTemplatePostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class TemplatePostController extends Controller
{
    /**
     * @Route("/cms/admin/viewtemplatepost", name="view_template_post")
     * @Method({"GET","POST"})
     * @return Response
     */

    public function viewTemplatePostAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            // Creation d'un nouvel objet template
            $template = new TemplatePost();
            $form = $this->createForm(AddTemplatePostType::class, $template);
            $formEdit = $this->createForm(EditTemplatePostType::class, $template);

            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Template:viewTemplatePost.html.twig', array(
                'listTemplate' => $listTemplate,
                'formEdit' => $formEdit->createView(),
                'form' => $form->createView()))->getContent();
            return new Response($response);

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }
    }
    /**
     * @Route("/cms/admin/loadviewtemplatepost", name="load_view_template_post")
     * @Method({"GET","POST"})
     * @return Response
     */

    public function loadViewTemplatePostAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            $postTest = $em->getRepository('SfCmsProjectCmsBundle:Post')->findOneBy(array('name'=>'Titre du 1er article'));
            $response = $this->render('SfCmsProjectCmsBundle:Template:CustomPost/'.$request->get('name').'.html.twig', array(
                'post' => $postTest
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
     * @Route ("/cms/admin/addtemplatepostvalid", name="add_template_post_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function addTemplatePostValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $template = New TemplatePost();
        //Creation du formulaire d'édition
        $formEdit = $this->createForm(EditTemplatePostType::class, $template);
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            $template->setName(str_replace(' ','-',$request->get('name')));
            $template->setContent($request->get('content'));

            $em->persist($template);
            $em->flush();

            // Appel du service pour créer une vue du nouveau template
            $this->container->get('sf_cms_project_cms.CreateTemplateFile')->createTemplatePostFile($request->get('name'),$request->get('content'));

            // Creation d'un nouvel objet template
            $template = new TemplatePost();
            $form = $this->createForm(AddTemplatePostType::class, $template);

            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Template:viewTemplatePost.html.twig', array(
                'listTemplate' => $listTemplate,
                'formEdit' => $formEdit->createView(),
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
     * @Route ("/cms/admin/edittemplatepostvalid", name="edit_template_post_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function editTemplatePostValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $this->container->get('sf_cms_project_cms.SupTemplateFile')->supTemplatePostFile($request->get('presentName'));
            $template = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findOneBy(array('name'=> $request->get('presentName')));
            $template->setName(str_replace(' ','-',$request->get('name')));
            $template->setContent($request->get('content'));

            $em->flush();

            // Appel du service pour créer une vue twig du nouveau template
            $this->container->get('sf_cms_project_cms.CreateTemplateFile')->createTemplatePostFile($request->get('name'),$request->get('content'));

            //Creation du formulaire d'édition
            $formEdit = $this->createForm(EditTemplatePostType::class, $template);
            // Creation d'un nouvel objet template
            $template = new TemplatePost();
            $form = $this->createForm(AddTemplatePostType::class, $template);

            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Template:viewTemplatePost.html.twig', array(
                'listTemplate' => $listTemplate,
                'formEdit' => $formEdit->createView(),
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
     * @Route ("/cms/admin/suptemplatepostvalid", name="sup_template_post_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function supTemplatePostValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $this->container->get('sf_cms_project_cms.SupTemplateFile')->supTemplatePostFile($request->get('name'));
            $template = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findOneBy(array('name'=> $request->get('name')));
            $listPost = $em->getRepository('SfCmsProjectCmsBundle:Post')->findBy(array('template' => $request->get('name')));
            foreach ($listPost as $post){
                $post->setTemplate(null);
            }
            $em->remove($template);
            $em->flush();

            // Creation d'un nouvel objet template
            $template = new TemplatePost();
            $form = $this->createForm(AddTemplatePostType::class, $template);
            //Creation du formulaire d'édition
            $formEdit = $this->createForm(EditTemplatePostType::class, $template);

            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Template:viewTemplatePost.html.twig', array(
                'listTemplate' => $listTemplate,
                'formEdit' => $formEdit->createView(),
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
     * @Route ("/cms/admin/updateformeditpost", name="update_form_edit_post")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function updateFormEditPostAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $template = $em->getRepository('SfCmsProjectCmsBundle:TemplatePost')->findOneBy(array('name'=> $request->get('presentName')));
            //Creation du formulaire d'édition
            $formEdit = $this->createForm(EditTemplatePostType::class, $template);

            $response = $this->render('SfCmsProjectCmsBundle:Template:formEditTemplatePost.html.twig', array(
                'formEdit' => $formEdit->createView()))->getContent();
            return new Response($response);

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }


}
