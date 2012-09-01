<?php

namespace Dvp\TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager; 
use Dvp\TeamBundle\Entity\Member; 
use Dvp\TeamBundle\Entity\Certification; 
use Dvp\TeamBundle\Entity\Role; 
use Dvp\TeamBundle\Entity\Website; 
use Dvp\TeamBundle\Entity\Section; 
use Dvp\TeamBundle\Entity\Category; 

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
    
    /** Original dump **/
/*
--
-- Table structure for table `membre_rang`
--

CREATE TABLE IF NOT EXISTS `membre_rang` (
  `id` bigint(20) NOT NULL auto_increment,
  `membre` bigint(20) default NULL,
  `rang` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `membre_idx` (`membre`),
  KEY `rang_idx` (`rang`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `membre_rang`
--

INSERT INTO `membre_rang` (`id`, `membre`, `rang`) VALUES
(8, 44506, 1),
(9, 44506, 2),
(10, 44506, 4),
(11, 44506, 5),
(12, 44506, 7),
(13, 44506, 8),
(14, 44506, 9),
(15, 254882, 1),
(16, 254882, 2),
(17, 254882, 3),
(18, 254882, 4),
(19, 254882, 5),
(20, 254882, 6),
(21, 254882, 7),
(22, 254882, 8),
(23, 254882, 9),
(24, 33090, 2),
(25, 33090, 4),
(26, 67052, 3),
(27, 67052, 4),
(29, 126136, 4),
(30, 292096, 3),
(31, 292096, 7),
(32, 292096, 9),
(33, 169573, 4),
(34, 193107, 7),
(35, 290340, 9),
(36, 341511, 9),
(37, 378458, 3),
(38, 345570, 8),
(39, 345570, 4),
(47, 333286, 7),
(48, 333286, 9),
(59, 268393, 2),
(60, 268393, 3),
(61, 268393, 5),
(62, 268393, 7),
(63, 268393, 8),
(66, 240267, 4),
(67, 57426, 3),
(68, 57426, 4),
(69, 161714, 4),
(70, 360054, 4),
(71, 33090, 12),
(72, 44506, 15),
(73, 193107, 12),
(74, 193107, 17),
(75, 240267, 16),
(76, 240267, 13),
(77, 268393, 13),
(78, 341511, 17),
(79, 360054, 14),
(80, 135545, 3),
(81, 135545, 4),
(82, 72448, 2),
(83, 72448, 4),
(84, 254882, 18),
(85, 254882, 19),
(86, 292096, 18),
(87, 408667, 9),
(88, 108609, 9),
(89, 352080, 3),
(90, 352080, 4),
(91, 352080, 7),
(92, 352080, 8),
(93, 352080, 16),
(94, 352080, 18),
(95, 352080, 19),
(98, 63689, 7),
(99, 135545, 2);

-- --------------------------------------------------------

--
-- Table structure for table `membre_site`
--

CREATE TABLE IF NOT EXISTS `membre_site` (
  `id` bigint(20) NOT NULL auto_increment,
  `url` text,
  `name` text,
  `membre` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `membre_idx` (`membre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `membre_site`
--

INSERT INTO `membre_site` (`id`, `url`, `name`, `membre`) VALUES
(1, 'http://tcuvelier.developpez.com', 'Articles divers et variés', 254882),
(2, 'http://blog.developpez.com/dourouc05/', 'Blog', 254882),
(3, 'http://www.jcourtois.fr/', 'Site personnel', 44506),
(4, 'http://jonathan-courtois.developpez.com/', 'Site personnel sur Developpez.com', 44506),
(5, 'http://blog.developpez.com/jonathan.courtois/', 'Blog', 44506),
(6, 'http://alp.developpez.com/', 'Articles', 67052),
(7, 'http://yan-verdavaine.developpez.com/', 'Articles', 33090),
(8, 'http://fhalgand.developpez.com/', 'Articles', 378458),
(11, 'http://gbelz.developpez.com/', 'Site Web', 268393),
(12, 'http://alexandre-laurent.developpez.com/', 'Site Web', 240267),
(13, 'http://www.Ikipou.com/', 'Site Web', 57426),
(14, 'http://blog.developpez.com/jiyuu', 'Blog', 135545),
(15, 'http://ceg.developpez.com/', 'Site Web', 135545),
(16, 'http://ymoreau.users.sourceforge.net ', 'Site Web', 72448);
*/
    // One-shot function. 
    public function importAction($dbHost, $dbDb, $dbUser, $dbPwd) {
        $dbh = new \PDO('mysql:host=' . $dbHost . ';dbname=' . $dbDb, $dbUser, $dbPwd);
        $em = $this->getDoctrine()->getManager(); 
        
        $certifs = $this->importCertifications($em, $dbh); 
        // $roles = $this->importRoles($em, $dbh); 
        $sections = $this->importSections($em); 
        $categories = $this->importCategories($em); 
        $members = $this->importMembers($em, $dbh, $sections, $categories); 
        $this->mapMembersWithCertifications($em, $dbh, $members, $certifs);
        
        //$em->flush(); 
    }
    
    private function importCertifications(EntityManager $em, \PDO $dbh) {
        $res = $dbh->query('SELECT * FROM `certif`');
        
        $certifs = array(); 
        
        while(($c = $res->fetch())) {
            $certif = new Certification(); 
            $certif->setName($c['nom'])
                   ->setImageUrl('http://qt.developpez.com/images/equipe/certifications/' . $c['image']); 
            
            $em->persist($certif);
            $certifs[$c['id']] = $certif; 
        }
        
        return $certifs;
    }
    
    private function importRoles(EntityManager $em, \PDO $dbh) {
        $res = $dbh->query('SELECT * FROM `rang`');
        
        $roles = array(); 
        
        while(($r = $res->fetch())) {
            $role = new Role(); 
            $role->setName(utf8_encode($r['nom']))
                 ->setUserAddable((bool) $r['useraddable']); 
            
            $em->persist($role);
            $roles[$r['id']] = $role; 
        }
        
        return $roles;
    }
    
    private function importSections(EntityManager $em) {
        $sections = array(); 
        
        $qtText = <<<EOD
<p class="presentation">
	Une petite équipe sympathique présente pour vous aider et qui essaie de contribuer à l'évolution de vos connaissances dans le domaine de la programmation avec Qt. Nous avons la vocation d'échange dans la simplicité et l'amitié, tout en respectant les consignes du site qui a la gentillesse d'héberger <a href="http://www.developpez.net/forums/f376/c-cpp/bibliotheques/qt/">nos forums</a> et nos modestes moyens (tels que la <a href="http://qt.developpez.com/faq/">FAQ</a>, les <a href="http://qt.developpez.com/tutoriels/">tutoriels</a>, les <a href="http://qt-quarterly.developpez.com/">traductions des Qt Quarterly</a>, les <a href="http://qt-labs.developpez.com/">traductions des Qt Labs</a>, les <a href="http://qt-devnet.developpez.com/">traductions du Qt Developer Network</a>, les <a href="http://qt.developpez.com/outils/">outils</a>, les <a href="http://qt.developpez.com/livres/">critiques de livres</a> et le <a href="http://blog.developpez.com/recap/qt">blog</a>), témoins de notre volonté d'échange dans une ambiance de franche amitié.
</p>
EOD;
        $pyqtText = <<<EOD
<p class="presentation">
	Une petite équipe sympathique présente pour vous aider et qui essaie de contribuer à l'évolution de vos connaissances dans le domaine de la programmation avec Qt et Python (PyQt et PySide principalement). Nous avons la vocation d'échange dans la simplicité et l'amitié, tout en respectant les consignes du site qui a la gentillesse d'héberger <a href="http://www.developpez.net/forums/f172/autres-langages/python-zope/gui/pyside-pyqt/">nos forums</a> et nos modestes moyens (tels que la <a href="http://pyqt.developpez.com/faq/">FAQ</a>, les <a href="http://pyt.developpez.com/tutoriels/">cours et tutoriels</a>, les <a href="http://qt-quarterly.developpez.com/">traductions des Qt Quarterly</a>, les <a href="http://qt-labs.developpez.com/">traductions des Qt Labs</a>, les <a href="http://qt-devnet.developpez.com/">traductions du Qt Developer Network</a>, les <a href="http://pyqt.developpez.com/livres/">critiques de livres</a>), témoins de notre volonté d'échange dans une ambiance de franche amitié.
</p> 
EOD;
        
        $sections['qt'] = new Section(); 
        $sections['qt']->setName('Qt')
                       ->setSlug('qt')
                       ->setGabId(65)
                       ->setImage('http://qt.developpez.com/images/equipe/logos/logo_equipe_qt.png')
                       ->setText($qtText);
        $em->persist($sections['qt']);
        
        $sections['pyqt'] = new Section(); 
        $sections['pyqt']->setName('PyQt et PySide')
                         ->setSlug('pyqt')
                         ->setGabId(102)
                         ->setImage('http://qt.developpez.com/images/equipe/logos/logo_equipe_qt_python.png')
                         ->setText($pyqtText);
        $em->persist($sections['pyqt']);
        
        return $sections; 
    }
    
    private function importCategories(EntityManager $em) {
        $categories = array(); 
        
        $categories[0] = new Category(); 
        $categories[0]->setName('Responsables')
                      ->setBold(true); 
        $em->persist($categories[0]);
        
        $categories[1] = new Category(); 
        $categories[1]->setName('Membres de la rédaction')
                      ->setBold(false); 
        $em->persist($categories[1]);
        
        $categories[2] = new Category(); 
        $categories[2]->setName('Anciens membres de la rédaction')
                      ->setBold(false); 
        $em->persist($categories[2]);
        
        $categories[3] = new Category(); 
        $categories[3]->setName('Hors rédaction')
                      ->setBold(false); 
        $em->persist($categories[3]);
        
        return $categories; 
    }
    
    private function importMembers(EntityManager $em, \PDO $dbh, array $sections, array $categories) {
        $res = $dbh->query('SELECT * FROM `membre`');
        
        $members = array(); 
        
        while(($m = $res->fetch())) {
            $member = new Member();
            $member->setFamilyName(utf8_encode($m['nom']))
                   ->setGivenName(utf8_encode($m['prenom']))
                   ->setForumId((int) $m['id'])
                   ->setPseudonym(utf8_encode($m['pseudo']))
                   ->setEmail($m['email'])
                   ->setShowEmail(true)
                   ->addSection($sections['qt']);
            
            if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/equipe/photos/' . utf8_encode($m['pseudo']) . '.jpg')) {
                $member->setPhoto('http://qt.developpez.com/images/equipe/photos/' . utf8_encode($m['pseudo']) . '.jpg'); 
            }
            
            if((bool) $m['pyside']) {
                $member->addSection($sections['pyqt']);
            }
            
            if((bool) $m['resp']) {
                $member->setCategory($categories[0]);
            } elseif((bool) $m['redac']) {
                $member->setCategory($categories[1]);
            } elseif((bool) $m['ancien']) {
                $member->setCategory($categories[2]);
            } else {
                $member->setCategory($categories[3]);
            }
            
            $em->persist($member);
            $members[$m['id']] = $member; 
        }
        
        return $members;
    }
    
    private function mapMembersWithCertifications(EntityManager $em, \PDO $dbh, array $members, array $certifs) {
        $res = $dbh->query('SELECT * FROM `membre_certif`');
        
        while(($m = $res->fetch())) {
            $members[$m['membre']]->addCertification($certifs[$m['certif']]); 
        }
    }
}
