<?php

/**
 * Loans filter form base class.
 *
 * @package    darwin
 * @subpackage filter
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLoansFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'to_date'           => new sfWidgetFormFilterInput(),
      'effective_to_date' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'              => new sfValidatorPass(array('required' => false)),
      'description'       => new sfValidatorPass(array('required' => false)),
      'status'            => new sfValidatorPass(array('required' => false)),
      'to_date'           => new sfValidatorPass(array('required' => false)),
      'effective_to_date' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('loans_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Loans';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'name'              => 'Text',
      'description'       => 'Text',
      'status'            => 'Text',
      'to_date'           => 'Text',
      'effective_to_date' => 'Text',
    );
  }
}
