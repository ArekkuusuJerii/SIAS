<?php
/**
 * Created by PhpStorm.
 * User: Pride White
 * Date: 10/10/2018
 * Time: 1:03 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{

    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        if (is_object($this->getUser())) {
            return $this->redirectTo('login_check');
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('AppBundle:default:login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    public function redirectAction()
    {
        $checker = $this->get('security.authorization_checker');
        if ($checker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_index');
        } else if ($checker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('user_index');
        } else {
            die();
        }
    }

    private function redirectTo($route)
    {
        return $this->redirect($this->generateUrl($route));
    }
}