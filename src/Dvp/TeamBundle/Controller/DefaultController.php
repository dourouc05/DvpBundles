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
    
        if(! $s) {
            $s = $this->getDoctrine()
                      ->getManager()
                      ->getRepository('DvpTeamBundle:Section')
                      ->findAll(); 
            $s = $s[0];
                      
            return $this->redirect($this->generateUrl('DvpTeamBundle_homepage', array('section' => $s->getSlug())));
        }
    
        $h = new Header('L\'équipe ' . $s->getName() . ' de Developpez.com', $s->getGabId());
        
        
        return $this->render('DvpTeamBundle:Default:index.html.twig', array('section' => $s, 'up' => $h->toHtml5()));
    }
}
