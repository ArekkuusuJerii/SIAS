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
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:admin:index.html.twig', array());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function projectAction(Request $request)
    {
        return $this->render('AppBundle:admin:project.html.twig', array(
            'items' => $this->makePagination('BackendBundle:Proyecto', $request)
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
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
        return $this->render('AppBundle:admin:admin_manage.html.twig', array(
            'previous_page' => 'admin_project',
            'title' => 'Crear Proyecto',
            'form' => $form->createView()
        ));
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function projectEditAction(Request $request, $id)
    {
        $project = $this->getManager()->getRepository('BackendBundle:Proyecto')->find($id);
        $form = $this->createForm(ProyectoType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($project);
            $manager->flush();
            return $this->redirectTo('admin_project');
        }
        return $this->render('AppBundle:admin:admin_manage.html.twig', array(
            'previous_page' => 'admin_project',
            'title' => 'Editar Proyecto',
            'form' => $form->createView()
        ));
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param $id
     * @return RedirectResponse
     */
    public function projectDeleteAction($id)
    {
        $manager = $this->getManager();
        $project = $manager->getRepository('BackendBundle:Proyecto')->find($id);
        $manager->remove($project);
        $manager->flush();
        return $this->redirectTo('admin_project');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function businessAction(Request $request)
    {
        return $this->render('AppBundle:admin:business.html.twig', array(
            'items' => $this->makePagination('BackendBundle:Empresa', $request)
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function businessCreateAction(Request $request)
    {
        $business = new Empresa();
        $form = $this->createForm(EmpresaType::class, $business);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($business);
            $manager->flush();
            return $this->redirectTo('admin_business');
        }
        return $this->render('AppBundle:admin:admin_manage.html.twig', array(
            'previous_page' => 'admin_business',
            'title' => 'Crear Empresa',
            'form' => $form->createView()
        ));
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function businessEditAction(Request $request, $id)
    {
        $business = $this->getManager()->getRepository('BackendBundle:Empresa')->find($id);
        $form = $this->createForm(EmpresaType::class, $business);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($business);
            $manager->flush();
            return $this->redirectTo('admin_business');
        }
        return $this->render('AppBundle:admin:admin_manage.html.twig', array(
            'previous_page' => 'admin_business',
            'title' => 'Editar Empresa',
            'form' => $form->createView(),
        ));
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param $id
     * @return RedirectResponse
     */
    public function businessDeleteAction($id)
    {
        $manager = $this->getManager();
        $business = $manager->getRepository('BackendBundle:Empresa')->find($id);
        $manager->remove($business);
        $manager->flush();
        return $this->redirectTo('admin_business');
    }

    /**
     * @param $repository
     * @param $request
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
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

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    private function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param $route
     * @return RedirectResponse
     */
    private function redirectTo($route)
    {
        return $this->redirect($this->generateUrl($route));
    }
}