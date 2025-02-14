<?php

/**
 * BaseBibliography
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $title
 * @property string $title_indexed
 * @property string $type
 * @property string $abstract
 * @property integer $year
 * @property Doctrine_Collection $CatalogueBibliography
 * 
 * @method integer             getId()                    Returns the current record's "id" value
 * @method string              getTitle()                 Returns the current record's "title" value
 * @method string              getTitleIndexed()          Returns the current record's "title_indexed" value
 * @method string              getType()                  Returns the current record's "type" value
 * @method string              getAbstract()              Returns the current record's "abstract" value
 * @method integer             getYear()                  Returns the current record's "year" value
 * @method Doctrine_Collection getCatalogueBibliography() Returns the current record's "CatalogueBibliography" collection
 * @method Bibliography        setId()                    Sets the current record's "id" value
 * @method Bibliography        setTitle()                 Sets the current record's "title" value
 * @method Bibliography        setTitleIndexed()          Sets the current record's "title_indexed" value
 * @method Bibliography        setType()                  Sets the current record's "type" value
 * @method Bibliography        setAbstract()              Sets the current record's "abstract" value
 * @method Bibliography        setYear()                  Sets the current record's "year" value
 * @method Bibliography        setCatalogueBibliography() Sets the current record's "CatalogueBibliography" collection
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <darwin-ict@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBibliography extends DarwinModel
{
    public function setTableDefinition()
    {
        $this->setTableName('bibliography');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('title', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('title_indexed', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('type', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('abstract', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('year', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('CatalogueBibliography', array(
             'local' => 'id',
             'foreign' => 'bibliography_ref'));
    }
}