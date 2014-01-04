<?php
// src/SIGESRHI/ExpedienteBundle/Twig/TelefonoExtension.php
namespace SIGESRHI\ExpedienteBundle\Twig;

class TelefonoExtension extends \Twig_Extension
{
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('telefono', array($this, 'telefonoFilter')),
        );
    }

    public function telefonoFilter($nit)
    {

        return substr($nit,0,4)."-".substr($nit,4,4);
        
    }

    public function getName()
    {
        return 'telefono_extension';
    }
}