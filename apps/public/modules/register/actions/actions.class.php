<?php

/**
 * search actions.
 *
 * @package    darwin
 * @subpackage search
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class registerActions extends DarwinActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new RegisterForm();
    $this->form->addLoginInfos(0);
    $this->form->addComm(0);
    $this->form->addLanguages(0);
    
    // If the search has been triggered by clicking on the search button or with pinned specimens
    if(($request->isMethod('post') && $request->getParameter('users','') !== '' ))
    {
      $captcha = array(
        'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
        'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
      );
      $this->form->bind(array_merge($request->getParameter('users'), array('captcha' => $captcha)));
      if ($this->form->isValid())
      {
        try
        {
          $this->user = $this->form->save();
          $this->user->addUserWidgets();
          $userInfos = $request->getParameter('users');
          $mail = '';
          if (isset($userInfos['RegisterCommForm'][0]['entry']))
            $mail = $userInfos['RegisterCommForm'][0]['entry'];
          $username = '';
          if (isset($userInfos['RegisterLoginInfosForm'][0]['user_name']))
            $username = $userInfos['RegisterLoginInfosForm'][0]['user_name'];
          $password = '';
          if (isset($userInfos['RegisterLoginInfosForm'][0]['new_password']))
            $password = $userInfos['RegisterLoginInfosForm'][0]['new_password'];
          $base_params =  array('physical' => $this->user->getIsPhysical(),
                                'name' => $this->user->getFormatedName(),
                                'title' => $this->user->getTitle()
                               );
          $suppl_params = array('mail' => $mail,
                                'username' => $username,
                                'password' => $password
                               );
          // send an email to the registered user
          $this->sendConfirmationMail(array_merge($base_params,$suppl_params));
          $this->redirect('register/succeeded?'.http_build_query($base_params));
        }
        catch(Doctrine_Exception $ne)
        {
          $e = new DarwinPgErrorParser($ne);
          $error = new sfValidatorError(new savedValidator(),$e->getMessage());
          $this->form->getErrorSchema()->addError($error);
        }
      }
    }
  }
  
  /*When registration succeeded redirect on a succeeded page with users parameter to be used*/
  public function executeSucceeded(sfWebRequest $request)
  {
    $this->params = array('physical'=> $request->getParameter('physical', 'physical'),
                          'name' => $request->getParameter('name', ''),
                          'title' => $request->getParameter('title', '')
                         );
  }

  public function executeLogin(sfWebRequest $request)
  {
    $this->redirectIf($this->getUser()->isAuthenticated(), $this->getContext()->getConfiguration()->generateFrontendUrl('homepage'));
    $referer = $this->getRequest()->getReferer();
    $this->form = new LoginForm();
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('login'));
      if ($this->form->isValid())
      {
        $this->getUser()->setAuthenticated(true);
        sfContext::getInstance()->getLogger()->debug('LOGIN: '.$this->form->getValue('username').' '.$this->form->user->getId() );
        $this->getUser()->setAttribute('db_user_id',$this->form->user->getId());
        $this->getUser()->setAttribute('db_user_type',$this->form->user->getDbUserType());
        $lang = Doctrine::getTable("UsersLanguages")->getPreferredLanguage($this->form->user->getId());
        if($lang) //prevent from crashing if lang is set
        {
            $this->getUser()->setCulture($lang->getLanguageCountry());
        }
        $this->redirect($this->getContext()->getConfiguration()->generateFrontendUrl('homepage'));
      }
      else
      {
        $this->getContext()->getConfiguration()->loadHelpers('Url');
        
        $this->redirect('board/index?l_err=1');
      }
    }
    $this->redirect($referer);
  }
  
  public function executeLogout(sfWebRequest $request)
  {
    $referer = $this->getRequest()->getReferer();
    $this->getUser()->clearCredentials();
    $this->getUser()->setAuthenticated(false);
    if(!$referer)
      $this->redirect($this->getContext()->getConfiguration()->generatePublicUrl('homepage'));
    else
      $this->redirect($referer);
  }
}
