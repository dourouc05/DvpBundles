<?php

namespace Dvp\TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dvp\GabaritBundle\Gabarit\Header; 

class DefaultController extends Controller
{
    public function indexAction($section)
    {
        $s = $this->getDoctrine()
                  ->getManager()
                  ->getRepository('DvpTeamBundle:Section')
                  ->findOneBySlug($section); 
    
        $h = new Header('L\'équipe ' . $s->getName() . ' de Developpez.com', $s->getGabId());
        
        return $this->render('DvpTeamBundle:Default:index.html.twig', array('name' => $section));
    }
}
