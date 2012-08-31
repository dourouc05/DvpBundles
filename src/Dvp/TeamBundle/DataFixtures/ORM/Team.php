<?php

namespace Dvp\TeamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dvp\TeamBundle\Entity\Member;
use Dvp\TeamBundle\Entity\Certification;
use Dvp\TeamBundle\Entity\Role;
use Dvp\TeamBundle\Entity\Website;
use Dvp\TeamBundle\Entity\Section;
use Dvp\TeamBundle\Entity\Category;

class LoadTeamData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $mgr)
    {
        $c = new Certification(); 
        $c->setName('Example certification')
          ->setImageUrl('http://example.com/cert.gif');
        
        $cat = new Category(); 
        $cat->setName('Maintainer');
        
        $r = new Role(); 
        $r->setName('Insignificant role')
          ->setUserAddable(true);
        
        $w = new Website(); 
        $w->setName('My website')
          ->setUrl('http://example.com/');
    
        $s = new Section(); 
        $s->setName('Useless section')
          ->setSlug('useless')
          ->setGabId(65)
          ->setImage('http://www.developpez.com/template/images/logo.png')
          ->setText('42');
    
        $m = new Member();
        $m->setFamilyName('Doe')
          ->setGivenName('John')
          ->setPseudonym('johndoe')
          ->setForumId(42)
          ->setEmail('john.doe@example.com')
          ->setShowEmail(true)
          ->addCertification($c)
          ->setCategory($cat)
          ->addRole($r)
          ->addWebsite($w)
          ->addSection($s);

        $mgr->persist($c);
        $mgr->persist($cat);
        $mgr->persist($r);
        $mgr->persist($w);
        $mgr->persist($s);
        $mgr->persist($m);
        $mgr->flush();
    }
}