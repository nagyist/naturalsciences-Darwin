<?php

/**
 * BaseCollectionsRights
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $collection_ref
 * @property integer $user_ref
 * @property integer $rights
 * @property Collections $Collections
 * @property Users $Users
 * 
 * @method integer           getCollectionRef()  Returns the current record's "collection_ref" value
 * @method integer           getUserRef()        Returns the current record's "user_ref" value
 * @method integer           getRights()         Returns the current record's "rights" value
 * @method Collections       getCollections()    Returns the current record's "Collections" value
 * @method Users             getUsers()          Returns the current record's "Users" value
 * @method CollectionsRights setCollectionRef()  Sets the current record's "collection_ref" value
 * @method CollectionsRights setUserRef()        Sets the current record's "user_ref" value
 * @method CollectionsRights setRights()         Sets the current record's "rights" value
 * @method CollectionsRights setCollections()    Sets the current record's "Collections" value
 * @method CollectionsRights setUsers()          Sets the current record's "Users" value
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseCollectionsRights extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('collections_rights');
        $this->hasColumn('collection_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('user_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('rights', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Collections', array(
             'local' => 'collection_ref',
             'foreign' => 'id'));

        $this->hasOne('Users', array(
             'local' => 'user_ref',
             'foreign' => 'id'));
    }
}