<?php

/**
 * BaseStagingPeople
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $referenced_relation
 * @property integer $record_id
 * @property string $people_type
 * @property string $people_sub_type
 * @property integer $order_by
 * @property integer $people_ref
 * @property string $formated_name
 * @property People $People
 * 
 * @method integer       getId()                  Returns the current record's "id" value
 * @method string        getReferencedRelation()  Returns the current record's "referenced_relation" value
 * @method integer       getRecordId()            Returns the current record's "record_id" value
 * @method string        getPeopleType()          Returns the current record's "people_type" value
 * @method string        getPeopleSubType()       Returns the current record's "people_sub_type" value
 * @method integer       getOrderBy()             Returns the current record's "order_by" value
 * @method integer       getPeopleRef()           Returns the current record's "people_ref" value
 * @method string        getFormatedName()        Returns the current record's "formated_name" value
 * @method People        getPeople()              Returns the current record's "People" value
 * @method StagingPeople setId()                  Sets the current record's "id" value
 * @method StagingPeople setReferencedRelation()  Sets the current record's "referenced_relation" value
 * @method StagingPeople setRecordId()            Sets the current record's "record_id" value
 * @method StagingPeople setPeopleType()          Sets the current record's "people_type" value
 * @method StagingPeople setPeopleSubType()       Sets the current record's "people_sub_type" value
 * @method StagingPeople setOrderBy()             Sets the current record's "order_by" value
 * @method StagingPeople setPeopleRef()           Sets the current record's "people_ref" value
 * @method StagingPeople setFormatedName()        Sets the current record's "formated_name" value
 * @method StagingPeople setPeople()              Sets the current record's "People" value
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStagingPeople extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('staging_people');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('referenced_relation', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('record_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('people_type', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'author',
             ));
        $this->hasColumn('people_sub_type', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('order_by', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('people_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('formated_name', 'string', null, array(
             'type' => 'string',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('People', array(
             'local' => 'people_ref',
             'foreign' => 'id'));
    }
}