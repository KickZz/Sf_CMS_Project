<?php

namespace SfCmsProject\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use SfCmsProject\CmsBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MenuController extends Controller
{
    /**
     * @param Request $request
     * @Route("/cms/admin/security/menu", name="menu")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function menuAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $query = $em->getRepository('SfCmsProjectCmsBundle:Icon')->getAll();
            $list = $query->getArrayResult();
            $listIcon = array();
            foreach ($list as $icon)
            {
                $arrayTmp = array('id' => $icon['id'] , 'value' => $icon['nameIcon'], 'desc' => $icon['viewIcon']);
                $listIcon[] = $arrayTmp;
            }

            // On vérifie le nombre de sous-page de chaque page
            $this->container->get('sf_cms_project_cms.CountSubPage')->countSubPage();
            $listPage = $em->getRepository('SfCmsProjectCmsBundle:Page')->findAllPageByOrderMenu();
            // On récupère toutes les pages
            $response = $this->render('SfCmsProjectCmsBundle:Menu:menu.html.twig', array(
                'listPage' => $listPage,
                'listIcon' => json_encode($listIcon, JSON_UNESCAPED_UNICODE)
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
     * @Route("/cms/admin/security/updatemenu", name="update_menu")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function updateMenuAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {
            $i = 0;
            foreach ($request->get('item') as $value ){
                $page = $em->getRepository('SfCmsProjectCmsBundle:Page')->findOneBy(array ('id' => $value));
                $page->setInsideMenu(true);
                $page->setOrderMenu($i);
                $page->setInsideSubMenu(false);
                $page->setIdSubMenu(0);
                // On actualise le nombre de sous-page de chaque page
                $this->container->get('sf_cms_project_cms.CountSubPage')->countSubPage();
                $em->flush();
                $i++;
            }
            return new Response();

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");

        }

    }
    /**
     * @param Request $request
     * @Route("/cms/admin/security/updatelistpage", name="update_list_page")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function updateListPageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {
            $i = 0;
            foreach ($request->get('item') as $value ){
                $page = $em->getRepository('SfCmsProjectCmsBundle:Page')->findOneBy(array ('id' => $value));
                $page->setInsideMenu(false);
                $page->setInsideSubMenu(false);
                $page->setIdSubMenu(0);
                $page->setOrderMenu($i);
                // On actualise le nombre de sous-page de chaque page
                $this->container->get('sf_cms_project_cms.CountSubPage')->countSubPage();
                $em->flush();
                $i++;
            }
            return new Response();

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }

    /**
     * @param Request $request
     * @param Page $page
     * @Route("/cms/admin/security/updateclasspage/{id}", name="update_class_page")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function updateClassPageAction(Request $request, Page $page)
    {
        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            // Comparaison des jetons CSRF
            if ($this->isCsrfTokenValid('csrf_maj_class', $request->get('csrf'))) {

                $page->setMyClassIcon($request->get('classCss'));
                $em->flush();

            }
            return new Response($request->get('classCss'));

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }
    /**
     * @param Request $request
     * @param Page $page
     * @Route("/cms/admin/security/updatesubmenu/{id}", name="update_sub_menu")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function updateSubMenuAction(Request $request, Page $page)
    {
        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

                $i = 0;
            if ($request->get('item') !== null){
                foreach ($request->get('item') as $value) {
                    $sousPage = $em->getRepository('SfCmsProjectCmsBundle:Page')->findOneBy(array('id' => $value));
                    $sousPage->setInsideMenu(true);
                    $sousPage->setInsideSubMenu(true);
                    $sousPage->setOrderMenu($i);
                    $sousPage->setIdSubMenu($page->getId());
                    $em->flush();
                    $i++;
                }

            }
            // On actualise le nombre de sous-page de chaque page
            $this->container->get('sf_cms_project_cms.CountSubPage')->countSubPage();

                return new Response();
            }

        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }
    /**
     * @param Request $request
     * @param Page $page
     * @Route("/cms/admin/security/updatecountsubpage/{id}", name="update_count_sub_page")
     * @return Response
     * @Method({"GET","POST"})
     */
    public function updateCountSubPageAction(Request $request, Page $page)
    {
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {
            // On retourne le nombre de sous page
            return new Response($page->getNumberSubPage());
        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }
}
