<?php
/**
 * Created by PhpStorm.
 * User: Pride White
 * Date: 12/1/2018
 * Time: 7:03 PM
 */

namespace BackendBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class ProyectoRepository extends EntityRepository
{
    /**
     * @param $project_id
     * @param $user_id
     * @return bool
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getIsLeader($project_id, $user_id)
    {
        $em = $this->getEntityManager();
        $builder = $em->createQueryBuilder();
        $query = $builder
            ->select('count(p.id)')
            ->from('BackendBundle:Proyecto', 'p')
            ->join('BackendBundle:Desarrollador', 'd', Join::WITH, 'p.id = d.proyecto')
            ->where('p.id = ?0')
            ->andWhere('d.usuario = ?1')
            ->andWhere($builder->expr()->in(
                'd.puesto',
                $em->createQueryBuilder()
                    ->select('p0.id')
                    ->from('BackendBundle:Puesto', 'p0')
                    ->where('p0.titulo like \'Líder\'')->getDQL()
            ));
        $query->setParameters(array($project_id, $user_id));
        /** @noinspection PhpUnhandledExceptionInspection */
        return $query->getQuery()->getSingleScalarResult() != 0;
    }

    /**
     * @param $project_id
     * @param $user_id
     * @return array
     */
    public function getActivities($project_id, $user_id)
    {
        $em = $this->getEntityManager();
        $builder = $em->createQueryBuilder();
        $query = $builder
            ->select('a')
            ->from('BackendBundle:Actividad', 'a')
            ->join('BackendBundle:Proyecto', 'p', Join::WITH, 'p.id = a.proyecto')
            ->where('p.id = ?0')
            ->andWhere($builder->expr()->in(
                'a.responsable',
                $em->createQueryBuilder()
                    ->select('d0.id')
                    ->from('BackendBundle:Desarrollador', 'd0')
                    ->where('d0.usuario = ?1')
                    ->getDQL()
            ));
        $query->setParameters(array($project_id, $user_id));
        return $query->getQuery()->getArrayResult();
    }

    /**
     * @param $project_id
     * @return int
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getProgress($project_id)
    {
        $em = $this->getEntityManager();
        $query = $em->getConnection()->prepare('call progress('.$project_id.')');
        $query->execute();
        return $query->fetchColumn(0);
    }
}