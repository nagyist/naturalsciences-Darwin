<?php

/**
 * Specimens form.
 *
 * @package    form
 * @subpackage Specimens
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class SpecimensForm extends BaseSpecimensForm
{
  public function configure()
  {
    $this->setDefaults(array(
        'gtu_ref' => 0,
        'expedition_ref' => 0,
    ));
    $this->widgetSchema->setNameFormat('specimen[%s]');
    $this->widgetSchema['collection_ref'] = new widgetFormButtonRef(array(
       'model' => 'Collections',
       'link_url' => 'collection/choose',
       'method' => 'getName',
       'box_title' => $this->getI18N()->__('Choose Collection'),
     ));

    $this->widgetSchema['expedition_ref'] = new widgetFormButtonRef(array(
       'model' => 'Expeditions',
       'link_url' => 'expedition/choose',
       'method' => 'getName',
       'box_title' => $this->getI18N()->__('Choose Expedition'),
       'nullable' => true,
     ));

    $this->widgetSchema['ig_ref'] = new widgetFormInputChecked(array('model' => 'Igs',
                                                                     'method' => 'getIgNum',
                                                                     'nullable' => true,
                                                                     'link_url' => 'igs/searchFor',
                                                                     'notExistingAddTitle' => $this->getI18N()->__('This I.G. number does not exist. Would you like to automatically insert it ?'),
                                                                     'notExistingAddValues' => array($this->getI18N()->__('Yes'),
                                                                                                     $this->getI18N()->__('No')
                                                                                                    ),
                                                                    )
                                                              );

    $this->widgetSchema['taxon_ref'] = new widgetFormButtonRef(array(
       'model' => 'Taxonomy',
       'link_url' => 'taxonomy/choose',
       'method' => 'getName',
       'box_title' => $this->getI18N()->__('Choose Taxon'),
     ));

    $this->widgetSchema['acquisition_category'] = new sfWidgetFormChoice(array(
      'choices' =>  SpecimensTable::getDistinctCategories(),
    ));

    $this->widgetSchema['accuracy'] = new sfWidgetFormChoice(array(
        'choices'  => array($this->getI18N()->__('exact'), $this->getI18N()->__('imprecise')),
        'expanded' => true,
    ));
    
    $this->widgetSchema['collecting_tool'] = new widgetFormSelectComplete(array(
        'model' => 'Specimens',
        'table_method' => 'getDistinctTools',
        'method' => 'getTool',
        'key_method' => 'getTool',
        'add_empty' => true,
	'change_label' => 'Pick a tool in the list',
	'add_label' => 'Add another tool',
    ));

    $this->widgetSchema['collecting_method'] = new widgetFormSelectComplete(array(
        'model' => 'Specimens',
        'table_method' => 'getDistinctMethods',
        'method' => 'getMethod',
        'key_method' => 'getMethod',
        'add_empty' => true,
	'change_label' => 'Pick a method in the list',
	'add_label' => 'Add another method',
    ));
    
    $this->validatorSchema['acquisition_category'] = new sfValidatorChoice(array(
        'choices' => SpecimensTable::getDistinctCategories(),
        'required' => false,
        ));

    $this->validatorSchema['accuracy'] = new sfValidatorChoice(array(
        'choices' => array(0,1),
        'required' => false,
        ));
        
    $this->validatorSchema['collection_ref'] = new sfValidatorInteger();
    $this->validatorSchema['expedition_ref'] = new sfValidatorInteger();
    $this->validatorSchema['taxon_ref'] = new sfValidatorInteger();

    $this->validatorSchema->setPostValidator(
        new sfValidatorSchemaCompare('specimen_count_min', '<=', 'specimen_count_max',
            array(),
            array('invalid' => 'The min number ("%left_field%") must be lower or equal the max number ("%right_field%")' )
            )
        );
    $this->setDefault('accuracy', 1);
//     $this->validatorSchema->setOption('allow_extra_fields', true);
  }
}