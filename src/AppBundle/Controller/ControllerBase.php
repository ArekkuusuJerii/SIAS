<?php
/**
 * Created by PhpStorm.
 * User: Pride White
 * Date: 11/30/2018
 * Time: 9:20 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ControllerBase extends Controller
{

    function defaultCreate($request, $entity, $form, $title = '', $prev = 'admin_index') {
        $form = $this->createForm($form, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($entity);
            $manager->flush();
            return $this->redirectTo($prev);
        }
        return $this->render('AppBundle:admin:admin_manage.html.twig', array(
            'previous_page' => $prev,
            'title' => $title,
            'form' => $form->createView()
        ));
    }

    function defaultEdit($request, $class, $form, $id, $title = '', $prev = 'admin_index') {
        $entity = $this->getManager()->getRepository($class)->find($id);
        $form = $this->createForm($form, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($entity);
            $manager->flush();
            return $this->redirectTo($prev);
        }
        return $this->render('AppBundle:admin:admin_manage.html.twig', array(
            'previous_page' => $prev,
            'title' => $title,
            'form' => $form->createView()
        ));
    }

    function defaultDelete($class, $id, $prev = 'admin_index') {
        $manager = $this->getManager();
        $business = $manager->getRepository($class)->find($id);
        $manager->remove($business);
        $manager->flush();
        return $this->redirectTo($prev);
    }

    /**
     * @param $repository
     * @param $request
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    function makePagination($repository, $request)
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
    function getManager()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @param $route
     * @return RedirectResponse
     */
    function redirectTo($route)
    {
        return $this->redirect($this->generateUrl($route));
    }
}