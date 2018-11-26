<?php
/**
 * Created by PhpStorm.
 * User: Pride White
 * Date: 11/25/2018
 * Time: 3:18 PM
 */

namespace AppBundle\Controller;

use BackendBundle\Entity\Empresa;
use BackendBundle\Entity\Proyecto;
use BackendBundle\Form\EmpresaType;
use BackendBundle\Form\ProyectoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Admin:index.html.twig', array());
    }

    public function projectAction(Request $request)
    {
        return $this->render('AppBundle:Admin:project.html.twig', array(
            'projects' => $this->makePagination('BackendBundle:Proyecto', $request)
        ));
    }

    public function projectCreateAction(Request $request)
    {
        $project = new Proyecto();
        $form = $this->createForm(ProyectoType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($project);
            $manager->flush();
            return $this->redirectTo('admin_project');
        }
        return $this->render('AppBundle:Admin:project_create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function businessCreateAction(Request $request)
    {
        $business = new Empresa();
        $form = $this->createForm(EmpresaType::class, $business);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($business);
            $manager->flush();
            return $this->redirectTo('admin_project_create');
        }
        return $this->render('AppBundle:Default:dialog.html.twig', array(
            'title' => 'Crear Empresa',
            'form' => $form->createView()
        ));
    }

    private function makePagination($repository, $request)
    {
        $query = $this->getManager()->getRepository($repository)->findAll();
        $paginator = $this->get('knp_paginator');
        return $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
    }

    private function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    private function redirectTo($route)
    {
        return $this->redirect($this->generateUrl($route));
    }
}