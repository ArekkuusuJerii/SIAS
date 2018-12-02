<?php
/**
 * Created by PhpStorm.
 * User: Pride White
 * Date: 11/25/2018
 * Time: 3:24 PM
 */

namespace AppBundle\Controller;

use BackendBundle\Entity\Actividad;
use BackendBundle\Form\ActividadType;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Symfony\Component\HttpFoundation\Request;

class UserController extends ControllerBase
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:user:index.html.twig', array(
            'items' => $this->makePagination('BackendBundle:Proyecto', $request),
        ));
    }

    /**
     * @ParamDecryptor(params={"id"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function activitiesAction(Request $request, $id)
    {
        $query = $this->getManager()->getRepository('BackendBundle:Proyecto');
        if (!$this->isLeader($id)) {
            $query = $query->getActivities($id, $this->getUser()->getId());
            if (!$query) $query = array();
        } else {
            $query = $query->find($id);
            $query = $query ? $query->getActividades() : array();
        }
        return $this->render('AppBundle:user:activities.html.twig', array(
            'items' => $this->makePaginationFromQuery($request, $query),
            'project_id' => $id,
            'is_leader' => $this->isLeader($id)
        ));
    }

    /**
     * @ParamDecryptor(params={"project_id"})
     * @param Request $request
     * @param $project_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function activityCreateAction(Request $request, $project_id)
    {
        $manager = $this->getManager();
        if (!$this->isLeader($project_id)) {
            return $this->redirect($this->generateUrl('user_activities', array(
                'id' => $this->get('nzo_url_encryptor')->encrypt($project_id)
            )));
        } else {
            $entity = new Actividad();
            $entity->setProyecto($manager->getRepository('BackendBundle:Proyecto')->find($project_id));
            $form = $this->createForm(ActividadType::class, $entity);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getManager();
                $manager->persist($entity);
                $manager->flush();
                return $this->redirect($this->generateUrl('user_activities', array(
                    'id' => $this->get('nzo_url_encryptor')->encrypt($project_id)
                )));
            }
            return $this->render($this->defaultManage(), array(
                'previous_page' => 'user_activities',
                'title' => 'Crear Actividad',
                'form' => $form->createView(),
                'id' => $project_id
            ));
        }
    }

    /**
     * @ParamDecryptor(params={"id","project_id"})
     * @param Request $request
     * @param $project_id
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function activityEditAction(Request $request, $project_id, $id)
    {
        if (!$this->isLeader($project_id)) {
            return $this->redirect($this->generateUrl('user_activities', array(
                'id' => $this->get('nzo_url_encryptor')->encrypt($project_id)
            )));
        } else {
            $entity = $this->getManager()->getRepository('BackendBundle:Actividad')->find($id);
            $form = $this->createForm(ActividadType::class, $entity);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getManager();
                $manager->persist($entity);
                $manager->flush();
                return $this->redirect($this->generateUrl('user_activities', array(
                    'id' => $this->get('nzo_url_encryptor')->encrypt($project_id)
                )));
            }
            return $this->render($this->defaultManage(), array(
                'previous_page' => 'user_activities',
                'title' => 'Editar Actividad',
                'form' => $form->createView(),
                'id' => $project_id
            ));
        }
    }

    /**
     * @ParamDecryptor(params={"id","project_id"})
     * @param $project_id
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function activityDeleteAction($project_id, $id)
    {
        if ($this->isLeader($project_id)) {
            $manager = $this->getManager();
            $business = $manager->getRepository('BackendBundle:Actividad')->find($id);
            $manager->remove($business);
            $manager->flush();
        }
        return $this->redirect($this->generateUrl('user_activities', array(
            'id' => $this->get('nzo_url_encryptor')->encrypt($project_id)
        )));
    }

    /**
     * @param $project_id
     * @return bool
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function isLeader($project_id)
    {
        $manager = $this->getManager();
        return $manager->getRepository('BackendBundle:Proyecto')->getIsLeader($project_id, $this->getUser()->getId());
    }

    /**
     * @ParamDecryptor(params={"id","$project_id"})
     * @param $project_id
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activityBeginAction($project_id, $id)
    {
        $manager = $this->getManager();
        $activity = $manager->getRepository('BackendBundle:Actividad')->find($id);
        if ($activity->getFechaInicioReal() == null) {
            $activity->setFechaInicioReal(new \DateTime());
            $manager->persist($activity);
            $manager->flush();
        }
        return $this->redirect($this->generateUrl('user_activities', array(
            'id' => $project_id
        )));
    }

    /**
     * @ParamDecryptor(params={"id","$project_id"})
     * @param $project_id
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activityCompleteAction($project_id, $id)
    {
        $manager = $this->getManager();
        $activity = $manager->getRepository('BackendBundle:Actividad')->find($id);
        if ($activity->getFechaFinReal() == null) {
            $activity->setFechaFinReal(new \DateTime());
            $manager->persist($activity);
            $manager->flush();
        }
        return $this->redirect($this->generateUrl('user_activities', array(
            'id' => $project_id
        )));
    }

    /**
     * @ParamDecryptor(params={"id","$project_id"})
     * @param $project_id
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activityRevertAction($project_id, $id)
    {
        $manager = $this->getManager();
        $activity = $manager->getRepository('BackendBundle:Actividad')->find($id);
        $activity->setFechaInicioReal(null);
        $activity->setFechaFinReal(null);
        $manager->persist($activity);
        $manager->flush();
        return $this->redirect($this->generateUrl('user_activities', array(
            'id' => $project_id
        )));
    }

    public function defaultManage()
    {
        return 'AppBundle:user:user_manage.html.twig';
    }
}