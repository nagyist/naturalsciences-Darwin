<?php

/**
 * lithostratigraphy actions.
 *
 * @package    darwin
 * @subpackage lithostratigraphy
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class lithostratigraphyActions extends DarwinActions
{
  protected $widgetCategory = 'catalogue_lithostratigraphy_widget';
  protected $table = 'lithostratigraphy';

  public function executeChoose(sfWebRequest $request)
  {
    $this->setLevelAndCaller($request);
    $this->searchForm = new LithostratigraphyFormFilter(array('table' => $this->table, 'level' => $this->level, 'caller_id' => $this->caller_id));
    $this->setLayout(false);
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless(
      $unit = Doctrine::getTable('Lithostratigraphy')->findExcept($request->getParameter('id')),
      sprintf('Object lithostratigraphy does not exist (%s).', array($request->getParameter('id')))
    );

    try
    {
      $unit->delete();
      $this->redirect('lithostratigraphy/index');
    }
    catch(Doctrine_Exception $ne)
    {
      $e = new DarwinPgErrorParser($ne);
      $error = new sfValidatorError(new savedValidator(),$e->getMessage());
      $this->form = new InstitutionsForm($institution);
      $this->form->getErrorSchema()->addError($error); 
      $this->loadWidgets();
      $this->setTemplate('edit');
    }
  }

  public function executeNew(sfWebRequest $request)
  {
    $new_litho = new Lithostratigraphy() ;
    $litho = $this->getRecordIfDuplicate('Lithostratigraphy', $request);
    // if there is no duplicate $litho is an empty array
    $new_litho->fromArray($litho) ;
    $this->form = new LithostratigraphyForm($new_litho);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new LithostratigraphyForm();
    $this->processForm($request,$this->form);
    $this->setTemplate('new');
  }
    
  public function executeEdit(sfWebRequest $request)
  {
    $unit = Doctrine::getTable('Lithostratigraphy')->findExcept($request->getParameter('id'));
    $this->forward404Unless($unit,'Unit not Found');
    $this->form = new LithostratigraphyForm($unit);
    $this->loadWidgets();

    $relations = Doctrine::getTable('CatalogueRelationships')->getRelationsForTable($this->table,$unit->getId());
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $unit = Doctrine::getTable('Lithostratigraphy')->find($request->getParameter('id'));
    $this->forward404Unless($unit,'Unit not Found');
    $this->form = new LithostratigraphyForm($unit);
    
    $relations = Doctrine::getTable('CatalogueRelationships')->getRelationsForTable($this->table,$unit->getId());
    $this->processForm($request,$this->form);
    $this->loadWidgets();
    $this->setTemplate('edit');
  }


  public function executeIndex(sfWebRequest $request)
  {
    $this->setLevelAndCaller($request);
    $this->searchForm = new LithostratigraphyFormFilter(array('table' => $this->table, 'level' => $this->level, 'caller_id' => $this->caller_id));
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind( $request->getParameter($form->getName()) );
    if ($form->isValid())
    {
      try{
	$form->save();
	$this->redirect('lithostratigraphy/edit?id='.$form->getObject()->getId());
      }
      catch(Doctrine_Exception $ne)
      {
	$e = new DarwinPgErrorParser($ne);
	$error = new sfValidatorError(new savedValidator(),$e->getMessage());
	$form->getErrorSchema()->addError($error); 
      }
    }
  }

}
