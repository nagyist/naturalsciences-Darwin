<?php

/**
 * user actions.
 *
 * @package    darwin
 * @subpackage user
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class userActions extends sfActions
{

  /**
    * Action executed when calling the expeditions from an other screen
    * @param sfWebRequest $request Request coming from browser
    */ 
  public function executeChoose(sfWebRequest $request)
  {
    $this->form = new UsersFormFilter();
    $this->setLayout(false);
  }

  public function executeProfile(sfWebRequest $request)
  {
    $this->user =  Doctrine::getTable('Users')->find( $this->getUser()->getAttribute('db_user_id') );
    $this->forward404Unless($this->user);


    $this->widgets = Doctrine::getTable('MyPreferences')
      ->setUserRef($this->getUser()->getAttribute('db_user_id'))
      ->getWidgets('users_widget');
  
    $old_people = $this->user->getPeopleId();

    $this->form = new UsersForm($this->user);
    if($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('users'));
      if($this->form->isValid())
      {
	  $this->form->updateObject();
	    
	  //If People Ref is changed
	  if($this->form->getValue('people_id') != $old_people)
	  {
	    if($this->form->getValue('people_id') != 0)
	      $this->form->getObject()->setApprovalLevel(1);
	    else
	      $this->form->getObject()->setApprovalLevel(0);
	  }
	  // Let's save the object
	  $this->form->getObject()->save();

	  if($this->form->getValue('password') != '')
	  {
	    $login_infos = $this->user->UsersLoginInfos;
	    if( count($login_infos) != 1)
	    {
	      print 'Ouups'; exit; // @TODO: replace this by a proper way
	    }
            $login_infos[0]->setPassword(sha1(sfConfig::get('app_salt').$this->form->getValue('password')));
	    $login_infos[0]->save();
	  }
	  return $this->redirect('user/profile');
      }
    }
  }

  public function executeAddress(sfWebRequest $request)
  {

    if($request->hasParameter('id'))
      $this->address =  Doctrine::getTable('UsersAddresses')->find($request->getParameter('id'));
    else
    {
     $this->address = new UsersAddresses();
     $this->address->setPersonUserRef($request->getParameter('ref_id'));
    }
     
    $this->form = new UsersAddressesForm($this->address);
    
    if($request->isMethod('post'))
    {
	$this->form->bind($request->getParameter('users_addresses'));
	if($this->form->isValid())
	{
	  try{
	    $this->form->save();
	  }
	  catch(Exception $e)
	  {
	    return $this->renderText($e->getMessage());
	  }
	  return $this->renderText('ok');
	}
    }
  }


  public function executeGetTags(sfWebRequest $request)
  {
    $this->array_possible = Doctrine::getTable('UsersComm')->getTags($request->getParameter('type'));
  }

  public function executeComm(sfWebRequest $request)
  {

    if($request->hasParameter('id'))
      $this->comm =  Doctrine::getTable('UsersComm')->find($request->getParameter('id'));
    else
    {
     $this->comm = new UsersComm();
     $this->comm->setPersonUserRef($request->getParameter('ref_id'));
    }
     
    $this->form = new UsersCommForm($this->comm);
    
    if($request->isMethod('post'))
    {
	$this->form->bind($request->getParameter('users_comm'));
	if($this->form->isValid())
	{
	  try{
	    $this->form->save();
	  }
	  catch(Exception $e)
	  {
	    return $this->renderText($e->getMessage());
	  }
	  return $this->renderText('ok');
	}
    }
  }

  public function executeLang(sfWebRequest $request)
  {

    if($request->hasParameter('id'))
      $this->lang =  Doctrine::getTable('UsersLanguages')->find($request->getParameter('id'));
    else
    {
     $this->lang = new UsersLanguages();
     $this->lang->setUsersRef($request->getParameter('ref_id'));
    }
     
    $this->form = new UsersLanguagesForm($this->lang);
    
    if($request->isMethod('post'))
    {
	$this->form->bind($request->getParameter('users_languages'));
	if($this->form->isValid())
	{
	  try {
	    if($this->form->getValue('preferred_language') && ! $this->lang->getPreferredLanguage() )
	    {
	      Doctrine::getTable('UsersLanguages')->removeOldPreferredLang($this->getUser()->getAttribute('db_user_id'));
	    }
	    
	    $this->form->save();
	    if($this->form->getValue('preferred_language'))
	    {
	      $this->getUser()->setCulture($this->form->getValue('language_country'));
	    }
	    
	    return $this->renderText('ok');
	  }
	  catch(Doctrine_Exception $e)
	  {
	    $error = new sfValidatorError(new savedValidator(),$e->getMessage());
	    $this->form->getErrorSchema()->addError($error); 
	  }
	}
    }
  }
}
