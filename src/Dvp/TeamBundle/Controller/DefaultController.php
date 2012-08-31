<?php

namespace Dvp\TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dvp\GabaritBundle\Gabarit\Header; 

class DefaultController extends Controller {
    public function indexAction($section) {
        /// Get page information. 
        $repoSection = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('DvpTeamBundle:Section'); 
    
        $section = $repoSection->findOneBySlug($section); 
    
        // Bad URL. Redirect to the first page. 
        if(! $section) {
            $section = $repoSection->findAll(); 
            return $this->redirect($this->generateUrl('DvpTeamBundle_homepage', array('section' => $section[0]->getSlug())));
        }
        
        /// Get page members (via the categories). 
        // $em = $this->getDoctrine()->getManager();
        // $q = $em->createQuery('SELECT m FROM DvpTeamBundle:Member m WHERE '); 
        $categories = $this->getDoctrine()
                           ->getManager()
                           ->getRepository('DvpTeamBundle:Category')
                           ->findAll(); 
        
        /// Get template. 
        $h = new Header('L\'équipe ' . $section->getName() . ' de Developpez.com', $section->getGabId());
        $f = ''; 
        
        /// Done. 
        return $this->render('DvpTeamBundle:Default:index.html.twig', array('section' => $section, 'categories' => $categories, 'up' => $h->toHtml5(), 'down' => $f));
    }
    
    public function importDataAction() {
    }
}
