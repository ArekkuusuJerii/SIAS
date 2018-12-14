<?php
/**
 * Created by PhpStorm.
 * User: Pride White
 * Date: 12/14/2018
 * Time: 11:26 AM
 */

namespace BackendBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;

class DesarrolladorRepository extends EntityRepository
{

    public function getAllNotLeaders($project)
    {
        $em = $this->getEntityManager();
        $builder = $em->createQueryBuilder();
        $query = $builder
            ->select('d')
            ->from('BackendBundle:Desarrollador', 'd')
            ->where($builder->expr()->notIn(
                'd.puesto',
                $em->createQueryBuilder()->select('p0.id')
                    ->from('BackendBundle:Puesto', 'p0')
                    ->where('p0.titulo like \'Líder\'')
                    ->getDQL()
            ));
        $query = $query->andWhere('d.proyecto = ?0');
        $query->setParameters(array($project));
        return $query;
    }

    /**
     * @param $project
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getAllDevelopers($project)
    {
        $em = $this->getEntityManager();
        $builder = $em->createQueryBuilder();
        $query = $builder
            ->select('d')
            ->from('BackendBundle:Desarrollador', 'd');
        if ($project) {
            $query = $query->where('d.proyecto = ?0 OR d.proyecto is null');
            $query->setParameters(array($project));
        } else {
            $query = $query->where('d.proyecto is null');
        }
        return $query;
    }
}