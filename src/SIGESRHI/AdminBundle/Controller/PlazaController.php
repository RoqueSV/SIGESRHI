<?php

namespace SIGESRHI\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SIGESRHI\AdminBundle\Entity\Plaza;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use APY\DataGridBundle\Grid\Grid;

/**
 * Plaza controller.
 *
 */
class PlazaController extends Controller
{
    /**
     * Lists all Plaza entities.
     *
     */
    public function indexAction()
    {
        $source = new Entity('AdminBundle:Plaza','grupo_plaza');
        
        $grid = $this->get('grid');
        
        //manipulando la Consulta del grid
        $tableAlias = $source->getTableAlias();
        $source->manipulateQuery(
            function($query) use ($tableAlias){
                $query->andWhere($tableAlias.'.nombreplaza != :p')
                      ->andWhere($tableAlias.'.nombreplaza != :pr')
                      ->setParameter('p','PRESIDENTE')
                      ->setParameter('pr','PRESIDENCIA');
            }
        );

        //Manipular Fila
        $source->manipulateRow(
            function ($row)
            {
                if(strlen($row->getField('misionplaza')) >= 200 ){
                   $row->setField('misionplaza', substr($row->getField('misionplaza'),0,200)." ...");          
                }//if
                return $row;
            }
        );
           
        $grid->setId('grid_plaza');
        $grid->setSource($source);              
        
    
        // Crear
       $rowAction1 = new RowAction('Seleccionar', 'plaza_ver');
       $grid->addRowAction($rowAction1);
        
        $grid->setLimits(array(5 => '5', 15 => '15', 25 => '25'));
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Seleccionar plaza", $this->get("router")->generate("plaza"));
        
        return $grid->getGridResponse('AdminBundle:Plaza:index.html.twig');
    }

    /**
     * Finds and displays a Plaza entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Plaza')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Plaza entity.');
        }
        
        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Seleccionar plaza", $this->get("router")->generate("plaza"));
        $breadcrumbs->addItem("Consultar plaza", $this->get("router")->generate("plaza_ver",array("id"=>$id)));

        return $this->render('AdminBundle:Plaza:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    public function documentacionAction()
    {

        // Incluimos camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Documentación solicitada", $this->get("router")->generate("documentacion_solicitada"));

        return $this->render('AdminBundle:Plaza:documentacion.html.twig');
    }

}
