<?php

/**
 * BaseTagGroups
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $tag_ref
 * @property string $group_name
 * @property string $group_name_indexed
 * @property string $sub_group_name
 * @property string $sub_group_name_indexed
 * @property string $color
 * @property Tags $Tags
 * @property Doctrine_Collection $GtuTags
 * 
 * @method integer             getId()                     Returns the current record's "id" value
 * @method integer             getTagRef()                 Returns the current record's "tag_ref" value
 * @method string              getGroupName()              Returns the current record's "group_name" value
 * @method string              getGroupNameIndexed()       Returns the current record's "group_name_indexed" value
 * @method string              getSubGroupName()           Returns the current record's "sub_group_name" value
 * @method string              getSubGroupNameIndexed()    Returns the current record's "sub_group_name_indexed" value
 * @method string              getColor()                  Returns the current record's "color" value
 * @method Tags                getTags()                   Returns the current record's "Tags" value
 * @method Doctrine_Collection getGtuTags()                Returns the current record's "GtuTags" collection
 * @method TagGroups           setId()                     Sets the current record's "id" value
 * @method TagGroups           setTagRef()                 Sets the current record's "tag_ref" value
 * @method TagGroups           setGroupName()              Sets the current record's "group_name" value
 * @method TagGroups           setGroupNameIndexed()       Sets the current record's "group_name_indexed" value
 * @method TagGroups           setSubGroupName()           Sets the current record's "sub_group_name" value
 * @method TagGroups           setSubGroupNameIndexed()    Sets the current record's "sub_group_name_indexed" value
 * @method TagGroups           setColor()                  Sets the current record's "color" value
 * @method TagGroups           setTags()                   Sets the current record's "Tags" value
 * @method TagGroups           setGtuTags()                Sets the current record's "GtuTags" collection
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseTagGroups extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tag_groups');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('tag_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('group_name', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('group_name_indexed', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('sub_group_name', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             ));
        $this->hasColumn('sub_group_name_indexed', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('color', 'string', null, array(
             'type' => 'string',
             'default' => '#FFFFFF',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Tags', array(
             'local' => 'tag_ref',
             'foreign' => 'id'));

        $this->hasMany('GtuTags', array(
             'local' => 'id',
             'foreign' => 'tag_group_ref'));
    }
}