<?php

/**
 * Codes form base class.
 *
 * @method Codes getObject() Returns the current form's model object
 *
 * @package    darwin
 * @subpackage form
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseCodesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'referenced_relation' => new sfWidgetFormTextarea(),
      'record_id'           => new sfWidgetFormInputText(),
      'code_category'       => new sfWidgetFormTextarea(),
      'code_prefix'         => new sfWidgetFormTextarea(),
      'code'                => new sfWidgetFormInputText(),
      'code_suffix'         => new sfWidgetFormTextarea(),
      'full_code_indexed'   => new sfWidgetFormTextarea(),
      'code_date'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'referenced_relation' => new sfValidatorString(),
      'record_id'           => new sfValidatorInteger(),
      'code_category'       => new sfValidatorString(array('required' => false)),
      'code_prefix'         => new sfValidatorString(array('required' => false)),
      'code'                => new sfValidatorInteger(array('required' => false)),
      'code_suffix'         => new sfValidatorString(array('required' => false)),
      'full_code_indexed'   => new sfValidatorString(array('required' => false)),
      'code_date'           => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('codes[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Codes';
  }

}
