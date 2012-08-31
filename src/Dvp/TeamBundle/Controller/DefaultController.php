<?php

namespace Dvp\TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($section)
    {
        return $this->render('DvpTeamBundle:Default:index.html.twig', array('name' => $section));
    }
}
