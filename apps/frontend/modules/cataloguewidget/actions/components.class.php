<?php

/**
 * account actions.
 *
 * @package    darwin
 * @subpackage board_widget
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class cataloguewidgetComponents extends sfComponents
{

  public function executeRelationRename()
  {
    $this->relations = Doctrine::getTable('CatalogueRelationships')->getRelationsForTable($this->table, $this->eid, 'current_name');
  }

  public function executeRelationRecombination()
  {
    $this->relations = Doctrine::getTable('CatalogueRelationships')->getRelationsForTable($this->table, $this->eid, 'recombined from');
  }

  public function executeComment()
  {
    $this->comments =  Doctrine::getTable('Comments')->findForTable($this->table, $this->eid);
  }

  public function executeProperties()
  {
    $this->properties =  Doctrine::getTable('CatalogueProperties')->findForTable($this->table, $this->eid);
  }

  public function executeSynonym()
  {
    $this->synonyms = Doctrine::getTable('ClassificationSynonymies')->findGroupForTable($this->table, $this->eid);
  }
}
