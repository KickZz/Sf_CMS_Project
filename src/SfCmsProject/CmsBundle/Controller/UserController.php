<?php

namespace SfCmsProject\CmsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SfCmsProject\CmsBundle\Entity\User;
use SfCmsProject\CmsBundle\Form\Type\AddUserType;
use SfCmsProject\CmsBundle\Form\Type\EditProfilUserType;
use SfCmsProject\CmsBundle\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class UserController extends Controller
{

    /**
     * @Route("/cms/admin/security/viewuser", name="view_user")
     * @Method({"GET","POST"})
     * @return Response
     */

    public function viewUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {

            $nbAdmin = count($em->getRepository('SfCmsProjectCmsBundle:User')->findUserByRoleAdmin());

            // Creation d'un nouvel objet template
            $user = new User();
            $form = $this->createForm(AddUserType::class, $user);

            $listUser = $em->getRepository('SfCmsProjectCmsBundle:User')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:User:viewUser.html.twig', array(
                'nbAdmin' => $nbAdmin,
                'listUser' => $listUser,
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
     * @Route ("/cms/admin/security/adduservalid", name="add_user_valid")
     * @Method({"GET","POST"})
     * @return Response
     */
    public function addUserValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $user = New User();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');

            if ($this->isCsrfTokenValid('csrf_add_user', $token)) {


                $user->setUsername($request->get('username'));
                $user->setPlainTextPassword($request->get('plainTextPassword'));
                $user->setEmail($request->get('email'));
                $user->setSignature($request->get('signature'));
                $user->setRoles($request->get('roles'));

                // Appel du service pour générer un salt de 16 caractères random
                $salt = $this->container->get('sf_cms_project_cms.SaltRandom')->randSalt();

                $user->setSalt($salt);

                $user->setPassword(md5($salt . $request->get('plainTextPassword')));
                $em->persist($user);
                $em->flush();

            }

            $nbAdmin = count($em->getRepository('SfCmsProjectCmsBundle:User')->findUserByRoleAdmin());
            // Creation d'un nouvel objet user
            $user = new User();
            $form = $this->createForm(AddUserType::class, $user);

            $listUser= $em->getRepository('SfCmsProjectCmsBundle:User')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:User:viewUser.html.twig', array(
                'nbAdmin' => $nbAdmin,
                'listUser' => $listUser,
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
     * @return Response
     * @Route ("/cms/admin/security/editprofiluser", name="edit_profil_user")
     * @Method({"GET","POST"})
     */
    public function editProfilUserAction(Request $request){

        // On récupère l'utilisateur courant
        $user = $this->getUser();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            // on crée un formulaire basé sur cet utilisateur
            $form = $this->createForm(EditProfilUserType::class, $user);

            $response = $this->render('SfCmsProjectCmsBundle:User:editProfilUser.html.twig', array(
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
     * @return Response
     * @Route ("/cms/admin/security/editprofiluservalid", name="edit_profil_user_valid")
     * @Method({"GET","POST"})
     */
    public function editProfilUserValidAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');

            if ($this->isCsrfTokenValid('csrf_edit_profil_user', $token)) {

                $user->setUsername($request->get('username'));
                $user->setPlainTextPassword($request->get('plainTextPassword'));
                $user->setEmail($request->get('email'));
                $user->setSignature($request->get('signature'));

                // Appel du service pour générer un salt de 16 caractères random
                $salt = $this->container->get('sf_cms_project_cms.SaltRandom')->randSalt();

                $user->setSalt($salt);

                $user->setPassword(md5($salt . $request->get('plainTextPassword')));
                $em->flush();
            }

            $nbAdmin = count($em->getRepository('SfCmsProjectCmsBundle:User')->findUserByRoleAdmin());

            // Creation d'un nouvel objet user
            $addUser = new User();
            $form = $this->createForm(AddUserType::class, $addUser);

            $listUser= $em->getRepository('SfCmsProjectCmsBundle:User')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:User:viewUser.html.twig', array(
                'nbAdmin' => $nbAdmin,
                'listUser' => $listUser,
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
     * @param User $user
     * @param $id
     * @return Response
     * @Route ("/cms/admin/security/edituser/{id}", name="edit_user", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function editUserAction(Request $request, User $user, $id){

        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {


            // on crée un formulaire basé sur cet utilisateur
            $form = $this->createForm(UserType::class, $user);

            $response = $this->render('SfCmsProjectCmsBundle:User:editUser.html.twig', array(
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
     * @param User $user
     * @return Response
     * @internal param $id
     * @Route ("/cms/admin/security/edituservalid/{id}", name="edit_user_valid", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function editUserValidAction(Request $request, User $user){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');

            if ($this->isCsrfTokenValid('csrf_edit_user', $token)) {


                $user->setRoles($request->get('roles'));

                $em->flush();
            }

            $nbAdmin = count($em->getRepository('SfCmsProjectCmsBundle:User')->findUserByRoleAdmin());

            // Creation d'un nouvel objet user
            $addUser = new User();
            $form = $this->createForm(AddUserType::class, $addUser);

            $listUser= $em->getRepository('SfCmsProjectCmsBundle:User')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:User:viewUser.html.twig', array(
                'nbAdmin' => $nbAdmin,
                'listUser' => $listUser,
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
     * @param User $user
     * @return Response
     * @Route ("/cms/admin/security/supuservalid/{id}", name="sup_user_valid", requirements={"id": "\d+"})
     * @Method({"GET","POST"})
     */
    public function supUserValidAction(Request $request, User $user){

        $em = $this->getDoctrine()->getManager();
        // Si la requête est en Ajax
        if ($request->isXmlHttpRequest()) {

            $token = $request->get('csrf');

            if ($this->isCsrfTokenValid('csrf_sup_this', $token)) {

                $em->remove($user);
                $em->flush();

            }

            $nbAdmin = count($em->getRepository('SfCmsProjectCmsBundle:User')->findUserByRoleAdmin());

            // Creation d'un nouvel objet user
            $addUser = new User();
            $form = $this->createForm(AddUserType::class, $addUser);

            $listUser= $em->getRepository('SfCmsProjectCmsBundle:User')->findAll();
            $response = $this->render('SfCmsProjectCmsBundle:User:viewUser.html.twig', array(
                'nbAdmin' => $nbAdmin,
                'listUser' => $listUser,
                'form' => $form->createView()))->getContent();
            return new Response($response);

        }
        else
        {
            throw new NotFoundHttpException("La page demandée n'existe pas");
        }

    }

}
