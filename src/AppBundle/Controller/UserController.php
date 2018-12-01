<?php
/**
 * Created by PhpStorm.
 * User: Pride White
 * Date: 11/25/2018
 * Time: 3:24 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:user:index.html.twig', array());
    }
}