<?php
// src/SIGESRHI/ExpedienteBundle/Twig/FormatoDuiExtension.php
namespace SIGESRHI\ExpedienteBundle\Twig;

class DuiExtension extends \Twig_Extension
{
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('dui', array($this, 'duiFilter')),
        );
    }

    public function duiFilter($dui)
    {

        return substr($dui,0,8)."-".substr($dui,8,1);
        
    }

    public function getName()
    {
        return 'dui_extension';
    }
}