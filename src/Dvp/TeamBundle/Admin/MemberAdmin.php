<?php

namespace Dvp\TeamBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class MemberAdmin extends Admin 
{
    protected $baseRouteName = 'dvp_admin_team_member';
    protected $baseRoutePattern = 'team/member';
    
    // public function getClass() {
        // return 'Dvp\\TeamBundle\\Entity\\Member';
    // }
    
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('familyName')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('familyName')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('familyName')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('pseudonym')
            ->add('familyName')
            ->add('givenName')
        ;
    }
}