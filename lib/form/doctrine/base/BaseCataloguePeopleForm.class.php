<?php

/**
 * CataloguePeople form base class.
 *
 * @method CataloguePeople getObject() Returns the current form's model object
 *
 * @package    darwin
 * @subpackage form
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseCataloguePeopleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'referenced_relation' => new sfWidgetFormTextarea(),
      'record_id'           => new sfWidgetFormInputText(),
      'people_type'         => new sfWidgetFormTextarea(),
      'order_by'            => new sfWidgetFormInputText(),
      'people_ref'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('People'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'referenced_relation' => new sfValidatorString(),
      'record_id'           => new sfValidatorInteger(),
      'people_type'         => new sfValidatorString(array('required' => false)),
      'order_by'            => new sfValidatorInteger(array('required' => false)),
      'people_ref'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('People'))),
    ));

    $this->widgetSchema->setNameFormat('catalogue_people[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CataloguePeople';
  }

}
