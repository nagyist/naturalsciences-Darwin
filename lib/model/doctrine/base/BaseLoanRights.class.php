<?php

/**
 * BaseLoanRights
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $loan_ref
 * @property integer $user_ref
 * @property boolean $has_encoding_right
 * @property Loans $Loan
 * @property Users $User
 * 
 * @method integer    getId()                 Returns the current record's "id" value
 * @method integer    getLoanRef()            Returns the current record's "loan_ref" value
 * @method integer    getUserRef()            Returns the current record's "user_ref" value
 * @method boolean    getHasEncodingRight()   Returns the current record's "has_encoding_right" value
 * @method Loans      getLoan()               Returns the current record's "Loan" value
 * @method Users      getUser()               Returns the current record's "User" value
 * @method LoanRights setId()                 Sets the current record's "id" value
 * @method LoanRights setLoanRef()            Sets the current record's "loan_ref" value
 * @method LoanRights setUserRef()            Sets the current record's "user_ref" value
 * @method LoanRights setHasEncodingRight()   Sets the current record's "has_encoding_right" value
 * @method LoanRights setLoan()               Sets the current record's "Loan" value
 * @method LoanRights setUser()               Sets the current record's "User" value
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLoanRights extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('loan_rights');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('loan_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('user_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('has_encoding_right', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Loans as Loan', array(
             'local' => 'loan_ref',
             'foreign' => 'id'));

        $this->hasOne('Users as User', array(
             'local' => 'user_ref',
             'foreign' => 'id'));
    }
}