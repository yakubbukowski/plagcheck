<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/8/2017
 * Time: 9:36 PM
 */

namespace AppBundle\Admin;

use AppBundle\Entity\Advantage;
use AppBundle\Entity\FeatureList;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;


class FeatureListAdmin extends AbstractAdmin
{
    public function toString($object)
    {
        return $object instanceof FeatureList
            ? $object->getListItemName()
            : 'Feature List'; // shown in the breadcrumb on the create view
    }


    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('listItemOrder', 'integer',array(
                'required' => true,
                'label' => 'Feature List Order'
            ))
            ->add('listItemName', 'text')
            ->add('icon', 'entity', array(
                'class' => 'AppBundle\Entity\Icon',
                'choice_label' => 'iconName',
                'required' => false,
            ))
            ->add('group', 'entity', array(
                'class' => 'AppBundle\Entity\FeatureListGroup',
                'choice_label' => 'listGroupName',
                'required' => false,
            ))
        ;

    }
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('listItemOrder')
            ->add('listItemName')
            ->add('group', null, array(), 'entity', array(
                'class' => 'AppBundle\Entity\FeatureListGroup',
                'choice_label' => 'listGroupName',
            ));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('listItemOrder')
            ->add('listItemName')
            ->add('group.listGroupName',null, array('label' => 'List Group ID'))
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
    }

    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'listItemOrder'
    );
}