<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new DarwinTestFunctional(new sfBrowser());
$browser->loadData($configuration)->login('root','evil');

$browser->
  info('Index')->
  get('/people/index')->
  
  with('request')->begin()->
    isParameter('module', 'people')->
    isParameter('action', 'index')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('.search_results_content')->
    checkElement('#people_filters_family_name')->
  end()->


  click('Search', array('people_filters' => array(
    'family_name' => array('text' => 'poil'),
    'is_physical' => 1,)
    )
  )->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('.results_container')->
    checkElement('.results_container .results > tbody > tr',2)->
    checkElement('.results_container .results > tbody > tr.hidden',1)->
  end()->

  get('/people/index')->
  click('Search', array('people_filters' => array(
    'family_name' => array('text' => 'ntol'),
    'is_physical' => 1,)
    )
  )->

  with('response')->begin()->
    isStatusCode(200)->
  end();

  $browser->test()->like($browser->getResponse()->getContent(),'/No Matching Items/','Content is ok');

  $browser->
  get('/people/index')->
  click('New')->

  with('response')->begin()->
    isStatusCode(200)->
  end()->

  click('Save', array('people' => array(
    'family_name'  => '',
    'additional_names' => '',
  )))->

  with('form')->begin()->
    hasErrors(1)->
    isError('family_name', 'required')->
  end()->

  click('Save', array('people' => array(
    'family_name'  => 'Dupont',
    'additional_names' => 'jr'
  )))->

  with('response')->begin()->
    isRedirected()->
  end()->

  followRedirect();

$nitems = Doctrine::getTable('People')->findByAdditionalNames('jr');

  $browser->
  test()->is($nitems[0]->getFamilyName(),'Dupont', 'We have the new encoded people');

  $browser->
  with('request')->begin()->
    isParameter('module', 'people')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
  end()->

  click('Save', array('people' => array(
    'family_name'  => 'Dupond',
    'additional_names' => 'jr'
  )))->

  with('response')->begin()->
    isRedirected()->
  end()->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'people')->
    isParameter('action', 'edit')->
  end()->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('input[value="Dupond"]')->

  end()->

  click('Delete')->
  with('response')->begin()->
    isRedirected()->
  end()->

  followRedirect()->

  with('request')->begin()->
    isParameter('module', 'people')->
    isParameter('action', 'index')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
  end();

$nitems = Doctrine::getTable('People')->findByAdditionalNames('jr');

  $browser->
  test()->is($nitems->count(),0, 'We have no matching people');

$browser->
  info('Address')->
  
  click('Search', array('people_filters' => array(
    'family_name' => array('text' => 'poil'),
    'is_physical' => 1,)
    )
  )->
  click('.edit a')->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#address tbody tr',0)->
  end()->
  
  click('#address a.link_catalogue')->
    with('response')->begin()->
    isStatusCode(200)->
  end()->

  click('Save')->
  with('response')->begin()->
    isStatusCode(200)->
  end()->

  with('form')->begin()->
    hasErrors(3)->
    isError('locality', 'required')->
    isError('country', 'required')->
    isError('tag', 'required')->
  end()->

  click('Save', array('people_addresses' => array(
    'locality'  => 'Bruxelles',
    'country' => 'Belgium',
    'tag' => 'home,pref'
  )))->

  with('response')->begin()->
    isStatusCode(200)->
  end();

  $browser->test()->like($browser->getResponse()->getContent(),'/ok/','Content is ok');

$browser->
  get('/people/index')->

  click('Search', array('people_filters' => array(
    'family_name' => array('text' => 'poil'),
    'is_physical' => 1,)
    )
  )->
  click('.edit a')->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#address tbody tr',1)->
    checkElement('#address tbody tr .tag',2)->
  end()->
  
  click('#address table tbody a.link_catalogue')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('input[value="Bruxelles"]')->
  end()->
  
  click('.widget_row_delete')->
   with('response')->begin()->
    isStatusCode(200)->
  end();

  $browser->test()->like($browser->getResponse()->getContent(),'/ok/','Content is ok');



$browser->
  info('Comm')->
  get('/people/index')->
  click('Search', array('people_filters' => array(
    'family_name' => array('text' => 'poil'),
    'is_physical' => 1,)
    )
  )->
  click('.edit a')->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#comm tbody tr',0)->
  end()->
  
  click('#comm a.link_catalogue')->
    with('response')->begin()->
    isStatusCode(200)->
  end()->

  click('Save')->
  with('response')->begin()->
    isStatusCode(200)->
  end()->

  with('form')->begin()->
    hasErrors(1)->
    isError('entry', 'required')->
  end()->

  click('Save', array('people_comm' => array(
    'entry'  => '+32478.254415',
    'comm_type' => 'TEL',
    'tag' => 'home'
  )))->

  with('response')->begin()->
    isStatusCode(200)->
  end();

  $browser->test()->like($browser->getResponse()->getContent(),'/ok/','Content is ok');

$browser->
  get('/people/index')->

  click('Search', array('people_filters' => array(
    'family_name' => array('text' => 'poil'),
    'is_physical' => 1,)
    )
  )->
  click('.edit a')->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#comm tbody tr',1)->
    checkElement('#comm tbody tr .tag','Home')->
  end()->
  
  click('#comm table tbody a.link_catalogue')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('input[value="+32478.254415"]')->
  end()->
  
  click('.widget_row_delete')->
   with('response')->begin()->
    isStatusCode(200)->
  end();

  $browser->test()->like($browser->getResponse()->getContent(),'/ok/','Content is ok');


$browser->
  info('Relation')->

  get('/people/index')->
  click('Search', array('people_filters' => array(
    'family_name' => array('text' => 'poil'),
    'is_physical' => 1,)
    )
  )->
  click('.edit a')->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#relation tbody tr',0)->
  end()->
  
  click('#relation a.link_catalogue')->
    with('response')->begin()->
    isStatusCode(200)->
  end()->

  click('Save')->
  with('response')->begin()->
    isStatusCode(200)->
  end()->

  with('form')->begin()->
    hasErrors(1)->
    isError('person_1_ref', 'required')->
  end();

$nitems = Doctrine::getTable('Institutions')->findOneByFamilyName('UGMM');

  $browser->
  click('Save', array('people_relationships' => array(
    'person_1_ref'  => $nitems->getId(),
    'relationship_type' => 'work for',
    'person_user_role' => 'Manager'
  )))->

  with('response')->begin()->
    isStatusCode(200)->
  end();

  $browser->test()->like($browser->getResponse()->getContent(),'/ok/','Content is ok');

$browser->
  get('/people/index')->

  click('Search', array('people_filters' => array(
    'family_name' => array('text' => 'poil'),
    'is_physical' => 1,)
    )
  )->
  click('.edit a')->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#relation tbody tr',1)->
  end()->
  
  click('#relation table tbody a.link_catalogue')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('input[value="Manager"]')->
  end()->
  
  click('.widget_row_delete')->
   with('response')->begin()->
    isStatusCode(200)->
  end();

  $browser->test()->like($browser->getResponse()->getContent(),'/ok/','Content is ok');



$browser->
  info('Lang')->

  get('/people/index')->
  click('Search', array('people_filters' => array(
    'family_name' => array('text' => 'poil'),
    'is_physical' => 1,)
    )
  )->
  click('.edit a')->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#lang tbody tr',0)->
  end()->
  
  click('#lang a.link_catalogue')->
    with('response')->begin()->
    isStatusCode(200)->
  end()->

  click('Save', array('people_languages' => array(
    'language_country'  => 'ddddddd',
    'mother' => '',
  )))->

  with('response')->begin()->
    isStatusCode(200)->
  end()->

  with('form')->begin()->
    hasErrors(1)->
    isError('language_country', 'invalid')->
  end();

  $browser->
  click('Save', array('people_languages' => array(
    'language_country'  => 'am',
    'mother' => 'yes',
  )))->

  with('response')->begin()->
    isStatusCode(200)->
  end();

  $browser->test()->like($browser->getResponse()->getContent(),'/ok/','Content is ok');

$browser->
  get('/people/index')->

  click('Search', array('people_filters' => array(
    'family_name' => array('text' => 'poil'),
    'is_physical' => 1,)
    )
  )->
  click('.edit a')->

  with('response')->begin()->
    isStatusCode(200)->
    checkElement('#lang tbody tr',1)->
  end()->
  
  click('#lang table tbody a.link_catalogue')->
  with('response')->begin()->
    isStatusCode(200)->
    checkElement('input[checked="checked"]')->
  end()->
  
  click('.widget_row_delete')->
   with('response')->begin()->
    isStatusCode(200)->
  end();

  $browser->test()->like($browser->getResponse()->getContent(),'/ok/','Content is ok');
