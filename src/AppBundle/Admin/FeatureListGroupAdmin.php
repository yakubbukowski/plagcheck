<?php

namespace AppBundle\Admin;

use AppBundle\Entity\FeatureListGroup;
use Doctrine\DBAL\Types\BooleanType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use ToolBox\FileBrowserBundle\Form\Type\FileBrowserType;

class FeatureListGroupAdmin extends AbstractAdmin
{


    public function toString($object)
    {
        return $object instanceof FeatureListGroup
            ? $object->getListGroupName()
            : 'Feature List Style Name'; // shown in the breadcrumb on the create view
    }

    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('listGroupName')
            ->add('listGroupTitle')
            ->add('listGroupOrder', 'integer',array(
                'required' => true,
                'label' => 'Feature List Group Order'
            ))
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('listGroupName')
            ->add('listGroupTitle')
            ->add('listGroupOrder')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('listGroupName')
            ->add('listGroupTitle')
            ->add('listGroupOrder')
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ));

    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->remove('delete');
    }

    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'listGroupOrder'
    );

}