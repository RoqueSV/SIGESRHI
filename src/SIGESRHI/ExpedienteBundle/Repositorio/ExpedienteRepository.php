<?php

namespace SIGESRHI\ExpedienteBundle\Repositorio;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * ExpedienteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExpedienteRepository extends EntityRepository
{
	public function obtenerExpediente($idexp)
    {
		return $this->getEntityManager()
			->createQuery('SELECT e.fechaexpediente fechaexpediente, s.nombres nombres, p.nombreplaza nombreplaza, t.nombretitulo nombretitulo,e.tipoexpediente,e.id id
                           FROM ExpedienteBundle:Solicitudempleo s JOIN s.idexpediente e JOIN s.idplaza p JOIN s.Destudios i JOIN i.idtitulo t
                           WHERE e.id=:idexp order by t.niveltitulo DESC
                           ')
			->setMaxResults(1)
            ->setParameter('idexp',$idexp)
            ->getResult();
	}

  public function obtenerExpedienteInvalido($idexp)
    {
    return $this->getEntityManager()
      ->createQuery("SELECT s.nombres, CONCAT(s.calle,CONCAT(', ',s.colonia)) as direccion, s.estadocivil, s.telefonofijo, s.telefonomovil, s.email, s.lugarnac, s.fechanac, s.fotografia,
                            s.dui,s.nit,s.isss,s.nup,s.nip
                           FROM ExpedienteBundle:Solicitudempleo s JOIN s.idexpediente e
                           WHERE e.id=:idexp
                           ")
            ->setParameter('idexp',$idexp)
            ->getResult();
  }
/**
*
* @GRID\Column(field="fechaexpediente", type="date")
*
*/

  public function obtenerExpedientes()
    {
    return $this->getEntityManager()
      ->createQuery('SELECT e.fechaexpediente fechaexpediente, s.nombres nombres, p.nombreplaza nombreplaza, t.nombretitulo nombretitulo,e.tipoexpediente
                           FROM ExpedienteBundle:Solicitudempleo s JOIN s.idexpediente e JOIN s.idplaza p JOIN s.Destudios i JOIN i.idtitulo t
                           order by t.niveltitulo DESC
                           ')    
       ->getResult();
          //quitamos result para retornar entidad no resultados
  }

  public function obtenerExpedientes2($limit = null)
  {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder('Expediente')
                   ->select('e.id')
                   ->from('Expediente', 'e');                   
        //$qb->add('select','e.id')
           //->add('from', 'ExpedienteBundle\Expediente e')
           //->add('where','e.id = ?1');

        if (false === is_null($limit))
            $qb->setMaxResults($limit);

        return $qb->getQuery();
                  
   }

}
