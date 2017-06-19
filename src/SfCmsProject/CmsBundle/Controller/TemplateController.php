<?php

namespace SfCmsProject\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SfCmsProject\CmsBundle\Entity\Template;
use SfCmsProject\CmsBundle\Form\Type\AddTemplateType;
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

            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:Template')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Template:viewTemplate.html.twig', array(
                'listTemplate' => $listTemplate,
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

            $viewTemplate = $em->getRepository('SfCmsProjectCmsBundle:Template')->findOneBy(array('name' => $request->get('name')));

            $response = $this->render('SfCmsProjectCmsBundle:Template:defaultTemplatePage.html.twig', array(
                'template' => $viewTemplate))->getContent();
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
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            $template->setName(str_replace(' ','-',$request->get('name')));
            $template->setContent($request->get('content'));

            $em->persist($template);
            $em->flush();

            $titre = str_replace(' ','-',$request->get('name'));
            $file = fopen('Resources/views/Template/Custom/'.$titre.'.html.twig',"a+" );
            fwrite($file,$request->get('content'));
            fclose($file);

            // Creation d'un nouvel objet template
            $template = new Template();
            $form = $this->createForm(AddTemplateType::class, $template);

            $listTemplate = $em->getRepository('SfCmsProjectCmsBundle:Template')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:Template:viewTemplate.html.twig', array(
                'listTemplate' => $listTemplate,
                'form' => $form->createView()))->getContent();
            return new Response($response);

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }


}