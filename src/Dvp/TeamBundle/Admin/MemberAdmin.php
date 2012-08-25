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
    // Show
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('pseudonym')
            ->add('givenName')
            ->add('familyName')
            ->add('forumId')
            ->add('email')
            ->add('showEmail')
            ->add('certifications')
            ->add('roles')
            ->add('category')
            ->add('sections')
            ->add('websites')
        ;
    }

    // Create, edit
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('pseudonym')
            ->add('givenName')
            ->add('familyName')
            ->add('forumId')
            ->add('email')
            ->add('showEmail')
            ->add('certifications')
            ->add('roles')
            ->add('category')
            ->add('sections')
            ->add('websites')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('familyName')
        ;
    }

    // List
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('pseudonym')
            ->add('forumId')
        ;
    }
}