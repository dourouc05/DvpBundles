<?php

namespace Dvp\TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dvp\TeamBundle\Importer\Sf1QtImporter; 

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
        $categories = $this->getDoctrine()
                           ->getManager()
                           ->getRepository('DvpTeamBundle:Category')
                           ->findAll(); 
        
        /// Done. 
        return $this->render('DvpTeamBundle:Default:index.html.twig', array('section' => $section, 'categories' => $categories));
    }
    
    // URL: /import/localhost/dvp/root/root
    // One-shot functions. 
    public function importAction($dbHost, $dbDb, $dbUser, $dbPwd) {
        $em = $this->getDoctrine()->getManager(); 
        $handler = new Sf1QtImporter($em, $dbHost, $dbDb, $dbUser, $dbPwd); 
        $handler->import(); 
        $em->flush(); 
    }
}
