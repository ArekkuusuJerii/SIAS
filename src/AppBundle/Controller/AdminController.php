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
use BackendBundle\Entity\Usuario;
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
     * @ParamDecryptor(params={"id"})
     * @param $id
     * @return Response
     * @throws \Doctrine\DBAL\DBALException
     */
    public function projectProgressAction($id)
    {
        $query = $this->getManager()->getRepository('BackendBundle:Proyecto');
        $projectProgress = $query->getProgress($id);
        return $this->render('AppBundle:default:dialog.html.twig', array(
            'projectProgress' => $projectProgress
        ));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function projectCreateAction(Request $request)
    {
        $entity = new Proyecto();
        $form = $this->createForm(ProyectoType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($entity);
            $manager->flush();
            $ds = $manager->getRepository('BackendBundle:Desarrollador')->findAll();
            foreach ($ds as $d) {
                if($entity->getDesarrolladores()->contains($d)) {
                    $d->setProyecto($entity);
                } else if($d->getProyecto() && $d->getProyecto()->getId() == $entity->getId()) {
                    $d->setProyecto(null);
                }
                $manager->persist($d);
            }
            $manager->flush();
            return $this->redirectTo('admin_project');
        }
        return $this->render($this->defaultManage(), array(
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
        $entity = $this->getManager()->getRepository('BackendBundle:Proyecto')->find($id);
        $form = $this->createForm(ProyectoType::class, $entity, array('project' => $id));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getManager();
            $manager->persist($entity);
            $manager->flush();
            $ds = $manager->getRepository('BackendBundle:Desarrollador')->findAll();
            foreach ($ds as $d) {
                if($entity->getDesarrolladores()->contains($d)) {
                    $d->setProyecto($entity);
                } else if($d->getProyecto() && $d->getProyecto()->getId() == $entity->getId()) {
                    $d->setProyecto(null);
                }
                $manager->persist($d);
            }
            $manager->flush();
            return $this->redirectTo('admin_project');
        }
        return $this->render($this->defaultManage(), array(
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
        $entity->setUsuario(new Usuario());
        $entity->getUsuario()->setRol('ROLE_USER');
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
            'title' => 'Editar Desarrollador',
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