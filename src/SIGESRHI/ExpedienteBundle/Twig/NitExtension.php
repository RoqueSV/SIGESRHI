<?php
// src/SIGESRHI/ExpedienteBundle/Twig/NitExtension.php
namespace SIGESRHI\ExpedienteBundle\Twig;

class NitExtension extends \Twig_Extension
{
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('nit', array($this, 'nitFilter')),
        );
    }

    public function nitFilter($nit)
    {

        return substr($nit,0,4)."-".substr($nit,4,6)."-".substr($nit,10,3)."-".substr($nit,13,1);
        
    }

    public function getName()
    {
        return 'nit_extension';
    }
}