<?php

/**
 * BaseUsersLoginInfos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_ref
 * @property string $login_type
 * @property string $user_name
 * @property string $password
 * @property string $system_id
 * @property timestamp $last_seen
 * @property Users $User
 * 
 * @method integer         getUserRef()    Returns the current record's "user_ref" value
 * @method string          getLoginType()  Returns the current record's "login_type" value
 * @method string          getUserName()   Returns the current record's "user_name" value
 * @method string          getPassword()   Returns the current record's "password" value
 * @method string          getSystemId()   Returns the current record's "system_id" value
 * @method timestamp       getLastSeen()   Returns the current record's "last_seen" value
 * @method Users           getUser()       Returns the current record's "User" value
 * @method UsersLoginInfos setUserRef()    Sets the current record's "user_ref" value
 * @method UsersLoginInfos setLoginType()  Sets the current record's "login_type" value
 * @method UsersLoginInfos setUserName()   Sets the current record's "user_name" value
 * @method UsersLoginInfos setPassword()   Sets the current record's "password" value
 * @method UsersLoginInfos setSystemId()   Sets the current record's "system_id" value
 * @method UsersLoginInfos setLastSeen()   Sets the current record's "last_seen" value
 * @method UsersLoginInfos setUser()       Sets the current record's "User" value
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseUsersLoginInfos extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('users_login_infos');
        $this->hasColumn('user_ref', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('login_type', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'local',
             ));
        $this->hasColumn('user_name', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('password', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('system_id', 'string', null, array(
             'type' => 'string',
             'primary' => true,
             ));
        $this->hasColumn('last_seen', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Users as User', array(
             'local' => 'user_ref',
             'foreign' => 'id'));
    }
}