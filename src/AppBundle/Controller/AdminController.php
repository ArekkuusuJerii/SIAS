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

    public function developerCreateAction(Request $request)
    {
        return $this->defaultCreate($request,
            new Desarrollador(),
            DesarrolladorType::class,
            'Crear Desarrollador',
            'admin_developer'
        );
    }

    public function developerEditAction(Request $request, $id)
    {
        return $this->defaultEdit($request,
            'BackendBundle:Desarrollador',
            DesarrolladorType::class, $id,
            'Editar Proyecto',
            'admin_project'
        );
    }

    public function developerDeleteAction($id)
    {
        return $this->defaultDelete(
            'BackendBundle:Desarrollador', $id,
            'admin_business'
        );
    }

    public function positionAction(Request $request)
    {
        return $this->render('AppBundle:admin:position.html.twig', array(
            'items' => $this->makePagination('BackendBundle:Puesto', $request)
        ));
    }

    public function positionCreateAction(Request $request)
    {
        return $this->defaultCreate($request,
            new Puesto(),
            PuestoType::class,
            'Crear Puesto',
            'admin_position'
        );
    }

    public function positionEditAction(Request $request, $id)
    {
        return $this->defaultEdit($request,
            'BackendBundle:Puesto',
            PuestoType::class, $id,
            'Editar Puesto',
            'admin_position'
        );
    }

    public function positionDeleteAction($id)
    {
        return $this->defaultDelete(
            'BackendBundle:Puesto', $id,
            'admin_position'
        );
    }
}