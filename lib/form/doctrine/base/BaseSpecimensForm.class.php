<?php

/**
 * Specimens form base class.
 *
 * @method Specimens getObject() Returns the current form's model object
 *
 * @package    darwin
 * @subpackage form
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseSpecimensForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'collection_ref'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Collections'), 'add_empty' => false)),
      'expedition_ref'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Expeditions'), 'add_empty' => true)),
      'gtu_ref'               => new sfWidgetFormInputText(),
      'taxon_ref'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Taxonomy'), 'add_empty' => true)),
      'litho_ref'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lithostratigraphy'), 'add_empty' => true)),
      'chrono_ref'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Chronostratigraphy'), 'add_empty' => true)),
      'lithology_ref'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lithology'), 'add_empty' => true)),
      'mineral_ref'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Mineralogy'), 'add_empty' => true)),
      'host_taxon_ref'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HostTaxon'), 'add_empty' => true)),
      'host_specimen_ref'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('HostSpecimen'), 'add_empty' => true)),
      'host_relationship'     => new sfWidgetFormTextarea(),
      'acquisition_category'  => new sfWidgetFormTextarea(),
      'acquisition_date_mask' => new sfWidgetFormInputText(),
      'acquisition_date'      => new sfWidgetFormDate(),
      'collecting_method'     => new sfWidgetFormTextarea(),
      'collecting_tool'       => new sfWidgetFormTextarea(),
      'specimen_count_min'    => new sfWidgetFormInputText(),
      'specimen_count_max'    => new sfWidgetFormInputText(),
      'station_visible'       => new sfWidgetFormInputCheckbox(),
      'multimedia_visible'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'collection_ref'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Collections'))),
      'expedition_ref'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Expeditions'), 'required' => false)),
      'gtu_ref'               => new sfValidatorInteger(array('required' => false)),
      'taxon_ref'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Taxonomy'), 'required' => false)),
      'litho_ref'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Lithostratigraphy'), 'required' => false)),
      'chrono_ref'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Chronostratigraphy'), 'required' => false)),
      'lithology_ref'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Lithology'), 'required' => false)),
      'mineral_ref'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Mineralogy'), 'required' => false)),
      'host_taxon_ref'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('HostTaxon'), 'required' => false)),
      'host_specimen_ref'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('HostSpecimen'), 'required' => false)),
      'host_relationship'     => new sfValidatorString(array('required' => false)),
      'acquisition_category'  => new sfValidatorString(array('required' => false)),
      'acquisition_date_mask' => new sfValidatorInteger(array('required' => false)),
      'acquisition_date'      => new sfValidatorDate(array('required' => false)),
      'collecting_method'     => new sfValidatorString(array('required' => false)),
      'collecting_tool'       => new sfValidatorString(array('required' => false)),
      'specimen_count_min'    => new sfValidatorInteger(array('required' => false)),
      'specimen_count_max'    => new sfValidatorInteger(array('required' => false)),
      'station_visible'       => new sfValidatorBoolean(array('required' => false)),
      'multimedia_visible'    => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('specimens[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Specimens';
  }

}
