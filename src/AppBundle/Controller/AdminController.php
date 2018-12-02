<?php
/**
 * Created by PhpStorm.
 * User: Pride White
 * Date: 11/25/2018
 * Time: 3:18 PM
 */

namespace AppBundle\Controller;

use BackendBundle\Entity\Desarrollador;
use BackendBundle\Entity\Empresa;
use BackendBundle\Entity\Proyecto;
use BackendBundle\Entity\Puesto;
use BackendBundle\Form\DesarrolladorType;
use BackendBundle\Form\EmpresaType;
use BackendBundle\Form\ProyectoType;
use BackendBundle\Form\PuestoType;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends ControllerBase
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
        return $this->defaultCreate($request,
            new Proyecto(),
            ProyectoType::class,
            'Crear Proyecto',
            'admin_project'
        );
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function projectEditAction(Request $request, $id)
    {
        return $this->defaultEdit($request,
            'BackendBundle:Proyecto',
            ProyectoType::class, $id,
            'Editar Proyecto',
            'admin_project'
        );
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param $id
     * @return RedirectResponse
     */
    public function projectDeleteAction($id)
    {
        return $this->defaultDelete(
            'BackendBundle:Proyecto', $id,
            'admin_project'
        );
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
        return $this->defaultCreate($request,
            new Empresa(),
            EmpresaType::class,
            'Crear Empresa',
            'admin_business'
        );
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function businessEditAction(Request $request, $id)
    {
        return $this->defaultEdit($request,
            'BackendBundle:Empresa',
            EmpresaType::class, $id,
            'Editar Empresa',
            'admin_business'
        );
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param $id
     * @return RedirectResponse
     */
    public function businessDeleteAction($id)
    {
        return $this->defaultDelete(
            'BackendBundle:Empresa', $id,
            'admin_business'
        );
    }

    public function developerAction(Request $request)
    {
        return $this->render('AppBundle:admin:developer.html.twig', array(
            'items' => $this->makePagination('BackendBundle:Desarrollador', $request)
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function developerCreateAction(Request $request)
    {
        $entity = new Desarrollador();
        $form = $this->createForm(DesarrolladorType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $encoder_factory = $this->get('security.encoder_factory');
            $encoder = $encoder_factory->getEncoder($entity->getUsuario());
            $password = $encoder->encodePassword($entity->getUsuario()->getPassword(), $entity->getUsuario()->getSalt());
            $entity->getUsuario()->setPassword($password);
            $manager->persist($entity);
            $manager->flush();
            return $this->redirectTo('admin_developer');
        }
        return $this->render('AppBundle:admin:admin_manage.html.twig', array(
            'previous_page' => 'admin_developer',
            'title' => 'Crear Desarrollador',
            'form' => $form->createView()
        ));
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function developerEditAction(Request $request, $id)
    {
        $entity = $this->getManager()->getRepository('BackendBundle:Desarrollador')->find($id);
        $form = $this->createForm(DesarrolladorType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $encoder_factory = $this->get('security.encoder_factory');
            $encoder = $encoder_factory->getEncoder($entity->getUsuario());
            $password = $encoder->encodePassword($entity->getUsuario()->getPassword(), $entity->getUsuario()->getSalt());
            $entity->getUsuario()->setPassword($password);
            $manager->persist($entity);
            $manager->flush();
            return $this->redirectTo('admin_developer');
        }
        return $this->render('AppBundle:admin:admin_manage.html.twig', array(
            'previous_page' => 'admin_developer',
            'title' => 'Editar Proyecto',
            'form' => $form->createView()
        ));
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param $id
     * @return RedirectResponse
     */
    public function developerDeleteAction($id)
    {
        return $this->defaultDelete(
            'BackendBundle:Desarrollador', $id,
            'admin_developer'
        );
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function positionAction(Request $request)
    {
        return $this->render('AppBundle:admin:position.html.twig', array(
            'items' => $this->makePagination('BackendBundle:Puesto', $request)
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function positionCreateAction(Request $request)
    {
        return $this->defaultCreate($request,
            new Puesto(),
            PuestoType::class,
            'Crear Puesto',
            'admin_position'
        );
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function positionEditAction(Request $request, $id)
    {
        return $this->defaultEdit($request,
            'BackendBundle:Puesto',
            PuestoType::class, $id,
            'Editar Puesto',
            'admin_position'
        );
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param $id
     * @return RedirectResponse
     */
    public function positionDeleteAction($id)
    {
        return $this->defaultDelete(
            'BackendBundle:Puesto', $id,
            'admin_position'
        );
    }
}