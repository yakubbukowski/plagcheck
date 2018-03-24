<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Feature;
use Doctrine\DBAL\Types\BooleanType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use ToolBox\FileBrowserBundle\Form\Type\FileBrowserType;

class FeatureAdmin extends AbstractAdmin
{
    public $tbOptions = array(
        'multiple' => false,
        'image_directory' => '/images/feature',
        'thumbWidth' => 1920,
        'thumbHeight' => 1200,
        'cropOptions' => array(
            0 => array(
                'og' => array(
                    "title" => "Open Graph (facebook)",
                    "type" => "pixel",
                    "width" => 1200,
                    "height" => 630
                ),
                'thumb' => array(
                    "title" => "Thumbnail",
                    "type" => "pixel",
                    "width" => 1920,
                    "height" => 1200
                )
            ),
        )
    );

    public function configure()
    {
        parent::configure();
        $this->setTemplate('edit', 'SonataAdminBundle:CRUD:tb_file_browser_edit.html.twig');
    }

    public function toString($object)
    {
        return $object instanceof Feature
            ? $object->getFeatureTitle()
            : 'Feature Title'; // shown in the breadcrumb on the create view
    }

    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('featureTitle')
            ->add('featureText', CKEditorType::class,array(
                'required' => false,
            ))
            ->add('featureOrder', 'integer',array(
                'required' => true,
                'label' => 'Feature Order'
            ))
            ->add('listGroup', 'entity', array(
                'class' => 'AppBundle\Entity\FeatureListGroup',
                'choice_label' => 'listGroupName',
                'required' => false,
            ))

            ->add('featureOgImage', FileBrowserType::class, array(
                'options' => array(
                    'multiple' => false
                )
            ))

        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('featureTitle')
            ->add('featureText')
            ->add('featureOrder')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('featureTitle')
            ->add('listGroup.listGroupName')
            ->add('featureOrder')
            ->add('_action', null, array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
    }

    protected $datagridValues = array(
        '_sort_order' => 'ASC',
        '_sort_by' => 'featureOrder'
    );

}