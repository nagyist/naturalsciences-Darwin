<?php

/**
 * BaseClassificationSynonymies
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $referenced_relation
 * @property integer $record_id
 * @property integer $group_id
 * @property string $group_name
 * @property integer $basionym_record_id
 * @property integer $order_by
 * 
 * @method integer                  getId()                  Returns the current record's "id" value
 * @method string                   getReferencedRelation()  Returns the current record's "referenced_relation" value
 * @method integer                  getRecordId()            Returns the current record's "record_id" value
 * @method integer                  getGroupId()             Returns the current record's "group_id" value
 * @method string                   getGroupName()           Returns the current record's "group_name" value
 * @method integer                  getBasionymRecordId()    Returns the current record's "basionym_record_id" value
 * @method integer                  getOrderBy()             Returns the current record's "order_by" value
 * @method ClassificationSynonymies setId()                  Sets the current record's "id" value
 * @method ClassificationSynonymies setReferencedRelation()  Sets the current record's "referenced_relation" value
 * @method ClassificationSynonymies setRecordId()            Sets the current record's "record_id" value
 * @method ClassificationSynonymies setGroupId()             Sets the current record's "group_id" value
 * @method ClassificationSynonymies setGroupName()           Sets the current record's "group_name" value
 * @method ClassificationSynonymies setBasionymRecordId()    Sets the current record's "basionym_record_id" value
 * @method ClassificationSynonymies setOrderBy()             Sets the current record's "order_by" value
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseClassificationSynonymies extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('classification_synonymies');
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
             'notnull' => true,
             ));
        $this->hasColumn('group_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('group_name', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('basionym_record_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('order_by', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}