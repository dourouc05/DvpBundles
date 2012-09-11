<?php 

namespace Dvp\TeamBundle\Importer;

use Doctrine\ORM\EntityManager; 
use Dvp\TeamBundle\Entity\Member; 
use Dvp\TeamBundle\Entity\Certification; 
use Dvp\TeamBundle\Entity\Role; 
use Dvp\TeamBundle\Entity\Website; 
use Dvp\TeamBundle\Entity\Section; 
use Dvp\TeamBundle\Entity\Category; 

class Sf1QtImporter {
    private $dbh; 
    private $em; 

    public function __construct(EntityManager $em, $dbHost, $dbDb, $dbUser, $dbPwd) {
        $this->em = $em; 
        
        $this->dbh = new \PDO('mysql:host=' . $dbHost . ';dbname=' . $dbDb, $dbUser, $dbPwd);
    }
    
    public function import() {
        $certifs = $this->importCertifications(); 
        $roles = $this->importRoles(); 
        $sections = $this->importSections(); 
        $categories = $this->importCategories(); 
        $members = $this->importMembers($sections, $categories); 
        $this->mapMembersWithCertifications($members, $certifs);
        $this->mapMembersWithRoles($members, $roles);
        $this->importWebsites($members);
    }
    
    private function importCertifications() {
        $res = $this->dbh->query('SELECT * FROM `certif`');
        
        $certifs = array(); 
        
        while(($c = $res->fetch())) {
            $certif = new Certification(); 
            $certif->setName($c['nom'])
                   ->setImageUrl('http://qt.developpez.com/images/equipe/certifications/' . $c['image']); 
            
            $this->em->persist($certif);
            $certifs[$c['id']] = $certif; 
        }
        
        return $certifs;
    }
    
    private function importRoles() {
        $res = $this->dbh->query('SELECT * FROM `rang`');
        
        $roles = array(); 
        
        while(($r = $res->fetch())) {
            $role = new Role(); 
            $role->setName(utf8_encode($r['nom']))
                 ->setUserAddable((bool) $r['useraddable']); 
            
            $this->em->persist($role);
            $roles[$r['id']] = $role; 
        }
        
        return $roles;
    }
    
    private function importSections() {
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
        $this->em->persist($sections['qt']);
        
        $sections['pyqt'] = new Section(); 
        $sections['pyqt']->setName('PyQt et PySide')
                         ->setSlug('pyqt')
                         ->setGabId(102)
                         ->setImage('http://qt.developpez.com/images/equipe/logos/logo_equipe_qt_python.png')
                         ->setText($pyqtText);
        $this->em->persist($sections['pyqt']);
        
        return $sections; 
    }
    
    private function importCategories() {
        $categories = array(); 
        
        $categories[0] = new Category(); 
        $categories[0]->setName('Responsables')
                      ->setBold(true); 
        $this->em->persist($categories[0]);
        
        $categories[1] = new Category(); 
        $categories[1]->setName('Membres de la rédaction')
                      ->setBold(false); 
        $this->em->persist($categories[1]);
        
        $categories[2] = new Category(); 
        $categories[2]->setName('Anciens membres de la rédaction')
                      ->setBold(false); 
        $this->em->persist($categories[2]);
        
        $categories[3] = new Category(); 
        $categories[3]->setName('Hors rédaction')
                      ->setBold(false); 
        $this->em->persist($categories[3]);
        
        return $categories; 
    }
    
    private function importMembers(array $sections, array $categories) {
        $res = $this->dbh->query('SELECT * FROM `membre`');
        
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
            
            $this->em->persist($member);
            $members[$m['id']] = $member; 
        }
        
        return $members;
    }
    
    private function mapMembersWithCertifications(array $members, array $certifs) {
        $res = $this->dbh->query('SELECT * FROM `membre_certif`');
        
        while(($m = $res->fetch())) {
            $members[$m['membre']]->addCertification($certifs[$m['certif']]); 
        }
    }
    
    private function mapMembersWithRoles(array $members, array $roles) {
        $res = $this->dbh->query('SELECT * FROM `membre_rang`');
        
        while(($m = $res->fetch())) {
            $members[$m['membre']]->addRole($roles[$m['rang']]); 
        }
    }
    
    private function importWebsites(array $members) {
        $res = $this->dbh->query('SELECT * FROM `membre_site`');
        
        while(($m = $res->fetch())) {
            $site = new Website(); 
            $site->setName(utf8_encode($m['name']))
                 ->setUrl($m['url']); 
            $members[$m['membre']]->addWebsite($site);
            $this->em->persist($site);
        }
    }
}