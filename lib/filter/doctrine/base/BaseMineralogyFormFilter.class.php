<?php

/**
 * Mineralogy filter form base class.
 *
 * @package    darwin
 * @subpackage filter
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseMineralogyFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name_indexed'    => new sfWidgetFormFilterInput(),
      'name_order_by'   => new sfWidgetFormFilterInput(),
      'level_ref'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Level'), 'add_empty' => true)),
      'status'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'path'            => new sfWidgetFormFilterInput(),
      'parent_ref'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Parent'), 'add_empty' => true)),
      'code'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'classification'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'formule'         => new sfWidgetFormFilterInput(),
      'formule_indexed' => new sfWidgetFormFilterInput(),
      'cristal_system'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'            => new sfValidatorPass(array('required' => false)),
      'name_indexed'    => new sfValidatorPass(array('required' => false)),
      'name_order_by'   => new sfValidatorPass(array('required' => false)),
      'level_ref'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Level'), 'column' => 'id')),
      'status'          => new sfValidatorPass(array('required' => false)),
      'path'            => new sfValidatorPass(array('required' => false)),
      'parent_ref'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Parent'), 'column' => 'id')),
      'code'            => new sfValidatorPass(array('required' => false)),
      'classification'  => new sfValidatorPass(array('required' => false)),
      'formule'         => new sfValidatorPass(array('required' => false)),
      'formule_indexed' => new sfValidatorPass(array('required' => false)),
      'cristal_system'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mineralogy_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Mineralogy';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'name'            => 'Text',
      'name_indexed'    => 'Text',
      'name_order_by'   => 'Text',
      'level_ref'       => 'ForeignKey',
      'status'          => 'Text',
      'path'            => 'Text',
      'parent_ref'      => 'ForeignKey',
      'code'            => 'Text',
      'classification'  => 'Text',
      'formule'         => 'Text',
      'formule_indexed' => 'Text',
      'cristal_system'  => 'Text',
    );
  }
}
