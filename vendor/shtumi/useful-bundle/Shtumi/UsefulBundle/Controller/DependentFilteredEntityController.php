<?php

namespace Shtumi\UsefulBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\Response;

class DependentFilteredEntityController extends Controller
{

    public function getOptionsAction()
    {

        $em = $this->get('doctrine')->getManager();
        $request = $this->getRequest();
        $translator = $this->get('translator');

        $entity_alias = $request->get('entity_alias');
        $parent_id    = $request->get('parent_id');
        $elemento = $request->get('elemento'); //Nuevo by Roquet
        
        /* by Roquet */
        if ($parent_id == null){
            $parent_id = 0;
        }
      
        $empty_value  = $request->get('empty_value');

        $entities = $this->get('service_container')->getParameter('shtumi.dependent_filtered_entities');
        $entity_inf = $entities[$entity_alias];

        if (false === $this->get('security.context')->isGranted( $entity_inf['role'] )) {
            throw new AccessDeniedException();
        }
        
        /** by Roquet - Solo plazas vacantes */
        if ($elemento == 'sigesrhi_expedientebundle_contrataciontype_puesto'){
          $qb = $this->getDoctrine()
                ->getRepository($entity_inf['class'])
                ->createQueryBuilder('e')
                ->where('e.' . $entity_inf['parent_property'] . ' = :parent_id')
                ->andwhere('e.idempleado is null')
                ->orderBy('e.' . $entity_inf['order_property'], $entity_inf['order_direction'])
                ->setParameter('parent_id', $parent_id);
        }
        else{
        $qb = $this->getDoctrine()
                ->getRepository($entity_inf['class'])
                ->createQueryBuilder('e')
                ->where('e.' . $entity_inf['parent_property'] . ' = :parent_id')
                ->orderBy('e.' . $entity_inf['order_property'], $entity_inf['order_direction'])
                ->setParameter('parent_id', $parent_id);
        }

        if (null !== $entity_inf['callback']) {
            $repository = $qb->getEntityManager()->getRepository($entity_inf['class']);

            if (!method_exists($repository, $entity_inf['callback'])) {
                throw new \InvalidArgumentException(sprintf('Callback function "%s" in Repository "%s" does not exist.', $entity_inf['callback'], get_class($repository)));
            }

            $repository->$entity_inf['callback']($qb);
        }

        $results = $qb->getQuery()->getResult();

        if (empty($results)) {
            if ($elemento == 'sigesrhi_expedientebundle_contrataciontype_puesto' and $parent_id != NULL){ //by Roquet
                return new Response('<option value="">' .'No existen vacantes'. '</option>');
            }
            else{
            return new Response('<option value="">' . $translator->trans($entity_inf['no_result_msg']) . '</option>');
            }
        }

        $html = '';
        if ($empty_value !== false)
            $html .= '<option value="">' . $translator->trans($empty_value) . '</option>';

        $getter =  $this->getGetterName($entity_inf['property']);

        foreach($results as $result)
        {
            if ($entity_inf['property'])
                $res = $result->$getter();
            else $res = (string)$result;

            $html = $html . sprintf("<option value=\"%d\">%s</option>",$result->getId(), $res);
        }

        return new Response($html);

    }

    private function getGetterName($property)
    {
        $name = "get";
        $name .= mb_strtoupper($property[0]) . substr($property, 1);

        while (($pos = strpos($name, '_')) !== false){
            $name = substr($name, 0, $pos) . mb_strtoupper(substr($name, $pos+1, 1)) . substr($name, $pos+2);
        }

        return $name;

    }
}
