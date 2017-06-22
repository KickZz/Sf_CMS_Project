<?php

namespace SfCmsProject\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SfCmsProject\CmsBundle\Entity\Template;
use SfCmsProject\CmsBundle\Form\Type\AddTemplateType;
use SfCmsProject\CmsBundle\Form\Type\EditTemplateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class TemplateController extends Controller
{
    /**
     * @Route("/cms/admin/viewtemplate", name="view_template")
     * @Method({"GET","POST"})
     * @return Response
     */

    public function viewTemplateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            // Creation d'un nouvel objet template
            $template = new Template();
            $form = $this->createForm(AddTemplateType::class, $template);
            $formEdit = $this->createForm(EditTemplateType::class, $template);

            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:Template')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Template:viewTemplate.html.twig', array(
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
     * @Route("/cms/admin/loadviewtemplate", name="load_view_template")
     * @Method({"GET","POST"})
     * @return Response
     */

    public function loadViewTemplateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            $pageTest = $em->getRepository('SfCmsProjectCmsBundle:Page')->findOneBy(array('name'=>'Titre de la page'));
            $response = $this->render('SfCmsProjectCmsBundle:Template:Custom/'.$request->get('name').'.html.twig', array(
                'page' => $pageTest
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
     * @Route ("/cms/admin/addtemplatevalid", name="add_template_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function addTemplateValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $template = New Template();
        //Creation du formulaire d'édition
        $formEdit = $this->createForm(EditTemplateType::class, $template);
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            $template->setName(str_replace(' ','-',$request->get('name')));
            $template->setContent($request->get('content'));

            $em->persist($template);
            $em->flush();

            // Appel du service pour créer une vue du nouveau template
            $this->container->get('sf_cms_project_cms.CreateTemplateFile')->createTemplateFile($request->get('name'),$request->get('content'));

            // Creation d'un nouvel objet template
            $template = new Template();
            $form = $this->createForm(AddTemplateType::class, $template);

            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:Template')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Template:viewTemplate.html.twig', array(
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
     * @Route ("/cms/admin/edittemplatevalid", name="edit_template_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function editTemplateValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $this->container->get('sf_cms_project_cms.SupTemplateFile')->supTemplateFile($request->get('presentName'));
            $template = $em->getRepository('SfCmsProjectCmsBundle:Template')->findOneBy(array('name'=> $request->get('presentName')));
            $template->setName(str_replace(' ','-',$request->get('name')));
            $template->setContent($request->get('content'));

            $em->flush();

            // Appel du service pour créer une vue twig du nouveau template
            $this->container->get('sf_cms_project_cms.CreateTemplateFile')->createTemplateFile($request->get('name'),$request->get('content'));

            //Creation du formulaire d'édition
            $formEdit = $this->createForm(EditTemplateType::class, $template);
            // Creation d'un nouvel objet template
            $template = new Template();
            $form = $this->createForm(AddTemplateType::class, $template);

            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:Template')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Template:viewTemplate.html.twig', array(
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
     * @Route ("/cms/admin/suptemplatevalid", name="sup_template_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function supTemplateValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $this->container->get('sf_cms_project_cms.SupTemplateFile')->supTemplateFile($request->get('name'));
            $template = $em->getRepository('SfCmsProjectCmsBundle:Template')->findOneBy(array('name'=> $request->get('name')));
            $listPage = $em->getRepository('SfCmsProjectCmsBundle:Page')->findBy(array('template' => $request->get('name')));
            foreach ($listPage as $page){
               $page->setTemplate(null);
            }
            $em->remove($template);
            $em->flush();

            // Creation d'un nouvel objet template
            $template = new Template();
            $form = $this->createForm(AddTemplateType::class, $template);
            //Creation du formulaire d'édition
            $formEdit = $this->createForm(EditTemplateType::class, $template);

            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:Template')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Template:viewTemplate.html.twig', array(
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
     * @Route ("/cms/admin/updateformedit", name="update_form_edit")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function updateFormEditAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $template = $em->getRepository('SfCmsProjectCmsBundle:Template')->findOneBy(array('name'=> $request->get('presentName')));
            //Creation du formulaire d'édition
            $formEdit = $this->createForm(EditTemplateType::class, $template);

            $response = $this->render('SfCmsProjectCmsBundle:Template:formEditTemplatePage.html.twig', array(
                'formEdit' => $formEdit->createView()))->getContent();
            return new Response($response);

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }


}