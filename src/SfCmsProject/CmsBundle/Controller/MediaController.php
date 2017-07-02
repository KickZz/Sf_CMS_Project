<?php

namespace SfCmsProject\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SfCmsProject\CmsBundle\Entity\Image;
use SfCmsProject\CmsBundle\Form\Type\AddImageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MediaController extends Controller
{
    /**
     * @param Request $request
     * @Route("/cms/admin/security/mediastorage", name="media_storage")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function mediaStorageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            // On récupère tous les medias
            $listMedia = $em->getRepository('SfCmsProjectCmsBundle:Image')->findAll();

            $response = $this->render('SfCmsProjectCmsBundle:Media:mediaStorage.html.twig', array(
                'listMedia' => $listMedia,
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
     * @Route("/cms/admin/security/addmedia", name="add_media")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function addMediaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {


            // Creation d'un nouvel objet page
            $page = new Image();
            $form = $this->createForm(AddImageType::class, $page);


            $response = $this->render('SfCmsProjectCmsBundle:Media:formMedia.html.twig', array(
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
     * @Route ("/cms/admin/security/addmediavalid", name="add_media_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function addMediaValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $image = New Image();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            $media = $request->files->get('file');
            $image->setFile($media);
            $em->persist($image);
            $em->flush();

            // On récupère tous les medias
            $listMedia = $em->getRepository('SfCmsProjectCmsBundle:Image')->findAll();

            $response = $this->render('SfCmsProjectCmsBundle:Media:mediaStorage.html.twig', array(
                'listMedia' => $listMedia,
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
     * @Route ("/cms/admin/security/supmediavalid", name="sup_media_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function supMediaValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            $media = $em->getRepository('SfCmsProjectCmsBundle:Image')->find($request->get('id'));
            $em->remove($media);
            $em->flush();

            // On récupère tous les medias
            $listMedia = $em->getRepository('SfCmsProjectCmsBundle:Image')->findAll();

            $response = $this->render('SfCmsProjectCmsBundle:Media:mediaStorage.html.twig', array(
                'listMedia' => $listMedia,
            ))->getContent();

            return new Response($response);

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }

}
