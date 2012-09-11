<?php 

namespace Dvp\TeamBundle\Importer; 

use Doctrine\ORM\EntityManager; 
use Dvp\TeamBundle\Entity\Member; 
use Dvp\TeamBundle\Entity\Certification; 
use Dvp\TeamBundle\Entity\Role; 
use Dvp\TeamBundle\Entity\Website; 
use Dvp\TeamBundle\Entity\Section; 
use Dvp\TeamBundle\Entity\Category; 

abstract class Sf1Importer {
    protected $dbh; 
    protected $em; 

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
    
    abstract protected function getBaseUrlImages(); 
    abstract protected function getDefaultSection(); 
    abstract protected function importSections(); 
    abstract protected function finishMemberSections(array $pdoMember, Member $member, array $sections); 

    private function importCertifications() {
        $res = $this->dbh->query('SELECT * FROM `certif`');
        
        $certifs = array(); 
        
        while(($c = $res->fetch())) {
            $certif = new Certification(); 
            $certif->setName($c['nom'])
                   ->setImageUrl($this->getBaseUrlImages() . 'certifications/' . $c['image']); 
            
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
    
    protected function importMembers(array $sections, array $categories) {
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
                   ->addSection($sections[$this->getDefaultSection()]);
            
            if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/images/equipe/photos/' . utf8_encode($m['pseudo']) . '.jpg')) {
                $member->setPhoto($this->getBaseUrlImages() . 'photos/' . utf8_encode($m['pseudo']) . '.jpg'); 
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
            
            $this->finishMemberSections($m, $member, $sections);
            
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