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
-- Table structure for table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `id` bigint(20) NOT NULL auto_increment,
  `nom` text,
  `prenom` text,
  `pseudo` text,
  `resp` tinyint(1) default NULL,
  `redac` tinyint(1) default NULL,
  `ancien` tinyint(1) default NULL,
  `email` text,
  `valide` tinyint(1) NOT NULL,
  `pyside` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=408668 ;

--
-- Dumping data for table `membre`
--

INSERT INTO `membre` (`id`, `nom`, `prenom`, `pseudo`, `resp`, `redac`, `ancien`, `email`, `valide`, `pyside`) VALUES
(33090, 'Verdavaine', 'Yan', 'yan', 0, 1, 0, 'yan.verdavaine@redaction-developpez.com', 1, 0),
(44506, 'Courtois', 'Jonathan', 'johnlamericain', 1, 1, 0, 'jonathan.courtois@redaction-developpez.com', 1, 0),
(57426, 'Poulain', 'Benjamin', 'Ikipou', 0, 0, 0, 'ikipou@gmail.com', 1, 0),
(63689, 'Charles', 'Pierre-Fran�ois', 'charlespf', 0, 0, 0, 'charlespf38@hotmail.com', 1, 0),
(67052, 'Mestan', 'Alp', 'Alp', 0, 1, 0, 'alp@redaction-developpez.com', 1, 0),
(72448, 'Yoann', 'Moreau', 'YoniBlond', 0, 1, 0, 'moreau.yo@gmail.com', 1, 0),
(108609, 'Lo�c', 'Leguay', 'Loic31', 0, 0, 0, 'loic_leguay@yahoo.fr', 1, 0),
(126136, 'Jaffr�', 'Fran�ois', 'superjaja', 0, 1, 0, 'francois.jaffre@redaction-developpez.com', 1, 0),
(135545, 'Gentil', 'Charles-�lie', 'Jiyuu', 0, 1, 0, 'gentilcharlie@yahoo.fr', 1, 1),
(161714, 'Decombe', 'Etienne', 'Gulish', 0, 0, 0, 'decombe.etienne@gmail.com', 1, 0),
(169573, 'Sorant', 'J�r�my', 'Niak74', 0, 0, 0, 'jsorant@gmail.com', 1, 0),
(193107, 'Bonnier', 'C�dric', 'myzu69', 0, 0, 0, 'myzu69@gmail.com', 1, 0),
(240267, 'Laurent', 'Alexandre', 'LittleWhite', 0, 1, 0, 'thedograge@hotmail.fr', 1, 0),
(254882, 'Cuvelier', 'Thibaut', 'dourouc05', 1, 1, 0, 'tcuvelier@redaction-developpez.com', 1, 1),
(268393, 'Belz', 'Guillaume', 'gbdivers', 0, 1, 0, 'guillaume.belz@free.fr', 1, 0),
(290340, 'Deladda', 'J�r�me', 'Attrox', 0, 0, 0, 'jeromedeledda@gmail.com', 1, 0),
(292096, 'du Verdier', 'Louis', 'Amnell', 0, 1, 0, 'zemassacreur@yahoo.fr', 1, 0),
(333286, 'Renault', 'Florent', 'GreatTux', 0, 0, 0, 'renault.florent@gmail.com', 1, 0),
(341511, 'Hafidi', 'Abdelhafid', 'std_abdel', 0, 0, 0, 'abdelite.algebra@gmail.com', 1, 0),
(345570, 'Genet', 'Francis', 'frifri59', 0, 0, 0, 'francis.genet@supinfo.com', 1, 0),
(352080, 'Meyer', 'Vincent', '0x4e84', 0, 0, 0, 'viinceent.meeyeer@gmail.com', 1, 1),
(360054, 'Rigal', 'Pierre-Nicolas', 'sysedit', 0, 0, 0, 'qt-contrib@p-n-r.com', 1, 0),
(378458, 'Halgand', 'Florentin', 'Architekth', 0, 0, 0, 'architekth@gmail.com', 1, 0),
(408667, 'Di Clemente', 'Emmanuel', 'manudiclemente', 0, 0, 0, 'manudiclemente@gmail.fr', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `membre_certif`
--

CREATE TABLE IF NOT EXISTS `membre_certif` (
  `id` bigint(20) NOT NULL auto_increment,
  `membre` bigint(20) default NULL,
  `certif` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `membre_idx` (`membre`),
  KEY `certif_idx` (`certif`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `membre_certif`
--

INSERT INTO `membre_certif` (`id`, `membre`, `certif`) VALUES
(1, 44506, 1),
(2, 360054, 1),
(3, 44506, 2),
(4, 44506, 3);

-- --------------------------------------------------------

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
(1, 'http://tcuvelier.developpez.com', 'Articles divers et vari�s', 254882),
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
        
        // $certifs = $this->importCertifications($em, $dbh); 
        // $roles = $this->importRoles($em, $dbh); 
        $sections = $this->importSections($em); 
        $categories = $this->importCategories($em); 
        $members = $this->importMembers($em, $dbh, $sections, $categories); 
        
        $em->flush(); 
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
	Une petite �quipe sympathique pr�sente pour vous aider et qui essaie de contribuer � l'�volution de vos connaissances dans le domaine de la programmation avec Qt. Nous avons la vocation d'�change dans la simplicit� et l'amiti�, tout en respectant les consignes du site qui a la gentillesse d'h�berger <a href="http://www.developpez.net/forums/f376/c-cpp/bibliotheques/qt/">nos forums</a> et nos modestes moyens (tels que la <a href="http://qt.developpez.com/faq/">FAQ</a>, les <a href="http://qt.developpez.com/tutoriels/">tutoriels</a>, les <a href="http://qt-quarterly.developpez.com/">traductions des Qt Quarterly</a>, les <a href="http://qt-labs.developpez.com/">traductions des Qt Labs</a>, les <a href="http://qt-devnet.developpez.com/">traductions du Qt Developer Network</a>, les <a href="http://qt.developpez.com/outils/">outils</a>, les <a href="http://qt.developpez.com/livres/">critiques de livres</a> et le <a href="http://blog.developpez.com/recap/qt">blog</a>), t�moins de notre volont� d'�change dans une ambiance de franche amiti�.
</p>
EOD;
        $pyqtText = <<<EOD
<p class="presentation">
	Une petite �quipe sympathique pr�sente pour vous aider et qui essaie de contribuer � l'�volution de vos connaissances dans le domaine de la programmation avec Qt et Python (PyQt et PySide principalement). Nous avons la vocation d'�change dans la simplicit� et l'amiti�, tout en respectant les consignes du site qui a la gentillesse d'h�berger <a href="http://www.developpez.net/forums/f172/autres-langages/python-zope/gui/pyside-pyqt/">nos forums</a> et nos modestes moyens (tels que la <a href="http://pyqt.developpez.com/faq/">FAQ</a>, les <a href="http://pyt.developpez.com/tutoriels/">cours et tutoriels</a>, les <a href="http://qt-quarterly.developpez.com/">traductions des Qt Quarterly</a>, les <a href="http://qt-labs.developpez.com/">traductions des Qt Labs</a>, les <a href="http://qt-devnet.developpez.com/">traductions du Qt Developer Network</a>, les <a href="http://pyqt.developpez.com/livres/">critiques de livres</a>), t�moins de notre volont� d'�change dans une ambiance de franche amiti�.
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
        $categories[1]->setName('Membres de la r�daction')
                      ->setBold(false); 
        $em->persist($categories[1]);
        
        $categories[2] = new Category(); 
        $categories[2]->setName('Anciens membres de la r�daction')
                      ->setBold(false); 
        $em->persist($categories[2]);
        
        $categories[3] = new Category(); 
        $categories[3]->setName('Hors r�daction')
                      ->setBold(false); 
        $em->persist($categories[3]);
        
        return $categories; 
    }
    
    private function importMembers(EntityManager $em, \PDO $dbh, array $sections) {
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
            
            if(file_exists($SERVER['DOCUMENT_ROOT'] . '/images/equipe/photos/' . utf8_encode($m['pseudo']) . '.jpg')) {
                $member->setPhoto('http://qt.developpez.com/images/equipe/photos/' . utf8_encode($m['pseudo']) . '.jpg'); 
            }
            
            if((bool) $m['pyside']) {
                $member->addSection($sections['pyqt']);
            }
            
            $em->persist($member);
            $members[$m['id']] = $member; 
        }
        
        return $members;
    }
}
