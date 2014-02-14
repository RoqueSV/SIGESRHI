<?php

namespace SIGESRHI\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use SIGESRHI\AdminBundle\Entity\Noticia;
use SIGESRHI\AdminBundle\Entity\Docnoticia;
use SIGESRHI\AdminBundle\Form\NoticiaType;
use Application\Sonata\UserBundle\Entity\User;
use SIGESRHI\ExpedienteBundle\Entity\Empleado;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\Column\ActionsColumn;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
/**
 * Noticia controller.
 *
 */
class NoticiaController extends Controller
{
    /**
     * Lists all Noticia entities.
     *
     */
    public function indexAction()
    {
        $source = new Entity('AdminBundle:Noticia','news');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $rowAction1 = new RowAction('Consultar', 'noticia_show');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id'));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);

        $grid->setId('grid_noticias');
        $grid->setDefaultOrder('fechanoticia','desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Noticias", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Noticias", $this->get("router")->generate("noticia"));
        return $grid->getGridResponse('AdminBundle:Noticia:index.html.twig');        
    }
    /**
    *List all Noticias to eliminate
    *
    */
    public function indexEliminarAction()
    {
        $source = new Entity('AdminBundle:Noticia','news');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $rowAction1 = new RowAction('Eliminar', 'noticia_confirm_delete');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id'));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);

        $grid->setId('grid_noticias');
        $grid->setDefaultOrder('fechanoticia','desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Noticias", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Eliminar Noticias", $this->get("router")->generate("noticia_indexdelete"));
        return $grid->getGridResponse('AdminBundle:Noticia:index.html.twig');        


        /*$em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Noticia')->findAll();

        return $this->render('AdminBundle:Noticia:index.html.twig', array(
            'entities' => $entities,
        ));*/
    }
    /**
    *prueba menu noticias a empleados...
    *
    */
    public function indexempleadoAction(){ 
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idempleado = $empleado->getId();
         //Obtener los centros del empleado
        $query2 = $em->createQuery("SELECT identity(u.idcentro)
                         FROM ExpedienteBundle:Empleado e JOIN e.idrefrenda r JOIN r.idunidad u 
                         WHERE e.id=:idempleado")                    
                    ->setParameter('idempleado',$idempleado);                    
        $resultado = $query2->setFirstResult(0)                            
                            ->getResult();
        $idcentros=array();
        //$idcentros[]=0;
        if(!is_null($resultado)){
            foreach ($resultado as $val) {
                foreach ($val as $v){
                    $idcentros[]=$v;
                }
            }
        }   
        else{
            $idcentros[]=0;
        }

        $source = new Entity('AdminBundle:Noticia','newsempleado');
        $grid = $this->get('grid');
        $grid->setSource($source);

        $source->manipulateQuery(
            function($query) use ($idcentros){
                $query->andWhere($query->expr()->in('_idcentro.id', $idcentros));                      
            }
        );        

        $rowAction1 = new RowAction('Consultar', 'noticia_showEmpleado');
        $rowAction1->setColumn('info_column');
        $rowAction1->manipulateRender(
            function ($action, $row)
            {
                $action->setRouteParameters(array('id'));
                return $action; 
            }
        );
        $grid->addRowAction($rowAction1);

        $grid->setId('grid_noticiasEmpleado');
        $grid->setDefaultOrder('fechanoticia','desc');
        $grid->setLimits(array(5 => '5', 10 => '10', 15 => '15'));
        
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Noticias", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Noticias", $this->get("router")->generate("noticia_indexempleado"));

        return $grid->getGridResponse('AdminBundle:Noticia:indexempleado.html.twig');          
    }

    /**
    *Vista de noticia a empleados...
    *
    */
    public function showEmpleadoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Noticia')->find($id);
        $var = $request->get('nogrid');
        $nogrid = (isset($var))?0:1;

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Noticia entity.');
        }
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Empleado", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Noticia", $this->get("router")->generate("noticia_indexempleado"));
        $breadcrumbs->addItem($entity->getAsuntonoticia(),"");
        return $this->render('AdminBundle:Noticia:showEmpleado.html.twig', array(
            'entity'      => $entity,
            'nogrid' => $nogrid,
            ));
    }

    /**
    *Renderiza las noticias en div para mostrarlos en el menu de noticias
    *
    */
    public function obtenerNoticiasAction(){
         $em = $this->getDoctrine()->getManager();
        $user = new User();
        $empleado = new Empleado();

        $user = $this->get('security.context')->getToken()->getUser();
        $empleado = $user->getEmpleado();
        $idempleado = $empleado->getId();


         //Obtener los centros del empleado
        $query2 = $em->createQuery("SELECT identity(u.idcentro)
                         FROM ExpedienteBundle:Empleado e JOIN e.idrefrenda r JOIN r.idunidad u 
                         WHERE e.id=:idempleado")                    
                    ->setParameter('idempleado',$idempleado);                    
        $resultado = $query2->setFirstResult(0)                            
                            ->getResult();
        $idcentros=array();
        //$idcentros[]=0;
        if(!is_null($resultado)){
            foreach ($resultado as $val) {
                foreach ($val as $v){
                    $idcentros[]=$v;
                }
            }
        }   
        else{
            $idcentros[]=0;
        }        
        $query = $em->createQueryBuilder()
            ->select('n.id,n.fechanoticia, n.asuntonoticia')
            ->from('AdminBundle:Noticia', 'n')
            ->innerJoin('n.idcentro', 'c')
            ->setMaxResults(5)
            ->andWhere('c.id IN (:idscentro)')
            ->groupBy('n.id')
            ->setParameter('idscentro', $idcentros);
        $noticias = $query->getQuery()->getResult();
        return $this->render('AdminBundle:Noticia:obtenerNoticias.html.twig', array(
       'noticias' => $noticias,
       'idcentro' => $idcentros,
        ));
    }

    /**
     * Creates a new Noticia entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Noticia();
        $em = $this->getDoctrine()->getManager();
        $entity -> setFechanoticia(new \Datetime(date('d-m-Y')));
        //$entity -> setFechanoticia(date('d-m-Y'));
        //$entity -> setFechanoticia('2014-01-02');
        $form = $this->createForm(new NoticiaType(), $entity);
        $form->bind($request);
        /*$arrayColc = array();
        $arrayColc2 = $entity->getIddocnoticia();
        foreach ($arrayColc2 as $Documento) {
            $arrayColc[]=$Documento;
            echo "VALL".$Documento->getRutadocnoticia();
        }  */  
        

        if ($form->isValid()) {                      
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('new','Noticia registrada correctamente');            
            return $this->redirect($this->generateUrl('noticia_show', array('id' => $entity->getId())));
        }

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Noticias", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Noticias", $this->get("router")->generate("noticia_new"));        
        $this->get('session')->getFlashBag()->add('errornew','Errores en el Registro de la Noticia');
        return $this->render('AdminBundle:Noticia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Noticia entity.
     *
     */
    public function newAction()
    {
        $entity = new Noticia();

       // $datosDocnoticias = new Docnoticia();
       // $datosDocnoticias->name = 'Docnoticia 1';
       // $entity->getIddocnoticia()->add($datosDocnoticias);

        $form   = $this->createForm(new NoticiaType(), $entity);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Noticias", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Registrar Noticias", $this->get("router")->generate("noticia_new"));
        return $this->render('AdminBundle:Noticia:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Noticia entity.
     *
     */
    public function showAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Noticia')->find($id);
        $var = $request->get('nogrid');
        $nogrid = (isset($var))?0:1;

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Noticia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Noticias", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Consultar Noticias", $this->get("router")->generate("noticia"));
        $breadcrumbs->addItem($entity->getAsuntonoticia(),"");
        return $this->render('AdminBundle:Noticia:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'centrosnoticia' => $entity->getIdcentro(),
            'nogrid' => $nogrid,
            ));
    }
    /**
    *Display info Noticia Confirm delete
    *
    */
    public function confirmdeleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Noticia')->find($id);
        $var = $request->get('nogrid');
        $nogrid = (isset($var))?0:1;

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Noticia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Noticias", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Eliminar Noticias", $this->get("router")->generate("noticia_indexdelete"));
        $breadcrumbs->addItem($entity->getAsuntonoticia(), "");
        return $this->render('AdminBundle:Noticia:showEliminar.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'centrosnoticia' => $entity->getIdcentro(),
            'nogrid' => $nogrid,
            ));
    }

    /**
     * Displays a form to edit an existing Noticia entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Noticia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Noticia entity.');
        }

        $editForm = $this->createForm(new NoticiaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);
        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Noticias", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Editar Noticias", $this->get("router")->generate("noticia"));
        $breadcrumbs->addItem($entity->getAsuntonoticia(),"");
        return $this->render('AdminBundle:Noticia:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Noticia entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Noticia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Noticia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new NoticiaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

        $this->get('session')->getFlashBag()->add('new','Noticia modificada correctamente');            
        return $this->redirect($this->generateUrl('noticia_show', array('id' => $entity->getId())));
            //return $this->redirect($this->generateUrl('noticia_edit', array('id' => $id)));
        }

        //Camino de migas
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Noticias", $this->get("router")->generate("hello_page"));
        $breadcrumbs->addItem("Editar Noticias", $this->get("router")->generate("noticia"));
        $breadcrumbs->addItem($entity->getAsuntonoticia(),"");
        $this->get('session')->getFlashBag()->add('errornew','Errores en la Modificación de la Noticia');
        return $this->render('AdminBundle:Noticia:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Noticia entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        //$form->bind($request);

        //if ($form->isValid()) {
        $from = $request->get('from');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AdminBundle:Noticia')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('new','Error al eliminar la Noticia');            
            return $this->redirect($this->generateUrl('noticia'));
            //throw $this->createNotFoundException('Unable to find Noticia entity.');
        }
        //eliminar archivo unlink
        $noticias = $entity->getIddocnoticia();
        foreach ($noticias as $noticia) {
            unlink($this->get('kernel')->getRootDir() . '/../web/uploads/docs_docsnoticia/'.$noticia->getRutadocnoticia());
            //$loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');            

        }        
        $em->remove($entity);
        $em->flush();
        //}
        $this->get('session')->getFlashBag()->add('new','Noticia eliminada correctamente');
        if($from==1)        
            return $this->redirect($this->generateUrl('noticia'));
        elseif ($from==2)
            return $this->redirect($this->generateUrl('noticia_indexdelete'));
    }

    /**
     * Creates a form to delete a Noticia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
