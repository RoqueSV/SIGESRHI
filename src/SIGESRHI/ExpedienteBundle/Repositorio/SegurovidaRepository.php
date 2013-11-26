<?php

namespace SIGESRHI\ExpedienteBundle\Repositorio;

use Doctrine\ORM\EntityRepository;

/**
 * SegurovidaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SegurovidaRepository extends EntityRepository
{
	public function obtenerDatosGenerales($idexp)
    {
		return $this->getEntityManager()
			->createQuery("SELECT e.id idexp,
				                  se.nombrecompleto nombre, 
				                  se.dui, 
				                  se.lugarnac, 
				                  se.fechanac, 
				                  concat(se.colonia,concat(', ',concat(COALESCE(se.calle,''), concat(' ',concat(m.nombremunicipio,concat('. ',d.nombredepartamento)))))) direccion
				           FROM ExpedienteBundle:Solicitudempleo se JOIN se.idexpediente e JOIN se.idmunicipio m JOIN m.iddepartamento d
				           WHERE e.id=:idexp 
                           ")
            ->setParameter('idexp',$idexp)
            ->getResult();
	}

	public function obtenerBeneficiarios($idexp,$estado)
    {
		return $this->getEntityManager()
			->createQuery("SELECT se.nombrecompleto,
				                  s.id idseguro,
				                  s.fechaseguro
				                  b.nombrebeneficiario beneficiario,
				                  b.parentesco,
				                  b.porcentaje  
				           FROM ExpedienteBundle:Beneficiario b 
				           JOIN b.idsegurovida s
				           JOIN s.idexpediente e
                           JOIN e.idsolicitudempleo se
 				           WHERE s.estadoseguro =:estado
				           AND e.id=:idexp 
                           ")
            ->setParameter('idexp',$idexp)
            ->setParameter('estado',$estado)
            ->getResult();
	}

}
