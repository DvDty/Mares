<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\UserEdit;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticationController extends Controller
{
    /**
     * @Route("/register", name="authentication_register")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $roleRepository = $this->getDoctrine()->getRepository(Role::class);
            $userRole = $roleRepository->findOneBy(['name' => 'ROLE_USER']);
            $user->addRole($userRole);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('authentication_login');
        }

        return $this->render('authentication/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/login", name="authentication_login")
     */
    public function loginAction()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('index');
        }

        return $this->render('authentication/login.html.twig');
    }

    /**
     * @Route("/logout", name="authentication_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/profile", name="authentication_profile_view")
     */
    public function viewProfileAction()
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('index');
        }

        return $this->render('authentication/viewProfile.html.twig');
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/profile/edit", name="authentication_profile_edit")
     */
    public function editProfileAction(Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('index');
        }

        $user = $this->getDoctrine()->getRepository(User::class)
            ->find($this->getUser()->getId());

        $form = $this->createForm(UserEdit::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('authentication_profile_view');
        }

        return $this->render('authentication/editProfile.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
