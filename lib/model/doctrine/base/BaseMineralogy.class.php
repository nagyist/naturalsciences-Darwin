<?php

/**
 * BaseMineralogy
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $name_indexed
 * @property string $name_order_by
 * @property integer $level_ref
 * @property string $status
 * @property string $path
 * @property integer $parent_ref
 * @property string $code
 * @property string $classification
 * @property string $formule
 * @property string $formule_indexed
 * @property string $cristal_system
 * @property Mineralogy $Parent
 * @property CatalogueLevels $Level
 * @property Doctrine_Collection $Mineralogy
 * @property Doctrine_Collection $Specimens
 * @property Doctrine_Collection $SpecimensAccompanying
 * @property Doctrine_Collection $SpecimenSearch
 * @property Doctrine_Collection $IndividualSearch
 * @property Doctrine_Collection $PartSearch
 * 
 * @method integer             getId()                    Returns the current record's "id" value
 * @method string              getName()                  Returns the current record's "name" value
 * @method string              getNameIndexed()           Returns the current record's "name_indexed" value
 * @method string              getNameOrderBy()           Returns the current record's "name_order_by" value
 * @method integer             getLevelRef()              Returns the current record's "level_ref" value
 * @method string              getStatus()                Returns the current record's "status" value
 * @method string              getPath()                  Returns the current record's "path" value
 * @method integer             getParentRef()             Returns the current record's "parent_ref" value
 * @method string              getCode()                  Returns the current record's "code" value
 * @method string              getClassification()        Returns the current record's "classification" value
 * @method string              getFormule()               Returns the current record's "formule" value
 * @method string              getFormuleIndexed()        Returns the current record's "formule_indexed" value
 * @method string              getCristalSystem()         Returns the current record's "cristal_system" value
 * @method Mineralogy          getParent()                Returns the current record's "Parent" value
 * @method CatalogueLevels     getLevel()                 Returns the current record's "Level" value
 * @method Doctrine_Collection getMineralogy()            Returns the current record's "Mineralogy" collection
 * @method Doctrine_Collection getSpecimens()             Returns the current record's "Specimens" collection
 * @method Doctrine_Collection getSpecimensAccompanying() Returns the current record's "SpecimensAccompanying" collection
 * @method Doctrine_Collection getSpecimenSearch()        Returns the current record's "SpecimenSearch" collection
 * @method Doctrine_Collection getIndividualSearch()      Returns the current record's "IndividualSearch" collection
 * @method Doctrine_Collection getPartSearch()            Returns the current record's "PartSearch" collection
 * @method Mineralogy          setId()                    Sets the current record's "id" value
 * @method Mineralogy          setName()                  Sets the current record's "name" value
 * @method Mineralogy          setNameIndexed()           Sets the current record's "name_indexed" value
 * @method Mineralogy          setNameOrderBy()           Sets the current record's "name_order_by" value
 * @method Mineralogy          setLevelRef()              Sets the current record's "level_ref" value
 * @method Mineralogy          setStatus()                Sets the current record's "status" value
 * @method Mineralogy          setPath()                  Sets the current record's "path" value
 * @method Mineralogy          setParentRef()             Sets the current record's "parent_ref" value
 * @method Mineralogy          setCode()                  Sets the current record's "code" value
 * @method Mineralogy          setClassification()        Sets the current record's "classification" value
 * @method Mineralogy          setFormule()               Sets the current record's "formule" value
 * @method Mineralogy          setFormuleIndexed()        Sets the current record's "formule_indexed" value
 * @method Mineralogy          setCristalSystem()         Sets the current record's "cristal_system" value
 * @method Mineralogy          setParent()                Sets the current record's "Parent" value
 * @method Mineralogy          setLevel()                 Sets the current record's "Level" value
 * @method Mineralogy          setMineralogy()            Sets the current record's "Mineralogy" collection
 * @method Mineralogy          setSpecimens()             Sets the current record's "Specimens" collection
 * @method Mineralogy          setSpecimensAccompanying() Sets the current record's "SpecimensAccompanying" collection
 * @method Mineralogy          setSpecimenSearch()        Sets the current record's "SpecimenSearch" collection
 * @method Mineralogy          setIndividualSearch()      Sets the current record's "IndividualSearch" collection
 * @method Mineralogy          setPartSearch()            Sets the current record's "PartSearch" collection
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMineralogy extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mineralogy');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('name_indexed', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('name_order_by', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('level_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('status', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'valid',
             ));
        $this->hasColumn('path', 'string', null, array(
             'type' => 'string',
             'notnull' => false,
             'default' => '/',
             ));
        $this->hasColumn('parent_ref', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('code', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('classification', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'strunz',
             ));
        $this->hasColumn('formule', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('formule_indexed', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('cristal_system', 'string', null, array(
             'type' => 'string',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Mineralogy as Parent', array(
             'local' => 'parent_ref',
             'foreign' => 'id'));

        $this->hasOne('CatalogueLevels as Level', array(
             'local' => 'level_ref',
             'foreign' => 'id'));

        $this->hasMany('Mineralogy', array(
             'local' => 'id',
             'foreign' => 'parent_ref'));

        $this->hasMany('Specimens', array(
             'local' => 'id',
             'foreign' => 'mineral_ref'));

        $this->hasMany('SpecimensAccompanying', array(
             'local' => 'id',
             'foreign' => 'mineral_ref'));

        $this->hasMany('SpecimenSearch', array(
             'local' => 'id',
             'foreign' => 'mineral_ref'));

        $this->hasMany('IndividualSearch', array(
             'local' => 'id',
             'foreign' => 'mineral_ref'));

        $this->hasMany('PartSearch', array(
             'local' => 'id',
             'foreign' => 'mineral_ref'));
    }
}