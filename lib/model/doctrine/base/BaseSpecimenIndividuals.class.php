<?php

/**
 * BaseSpecimenIndividuals
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $specimen_ref
 * @property string $type
 * @property string $type_group
 * @property string $type_search
 * @property string $sex
 * @property string $stage
 * @property string $stat
 * @property string $social_status
 * @property string $rock_form
 * @property integer $specimen_individuals_count_min
 * @property integer $specimen_individuals_count_max
 * @property Specimens $Specimens
 * @property Doctrine_Collection $SpecimenParts
 * 
 * @method integer             getId()                             Returns the current record's "id" value
 * @method integer             getSpecimenRef()                    Returns the current record's "specimen_ref" value
 * @method string              getType()                           Returns the current record's "type" value
 * @method string              getTypeGroup()                      Returns the current record's "type_group" value
 * @method string              getTypeSearch()                     Returns the current record's "type_search" value
 * @method string              getSex()                            Returns the current record's "sex" value
 * @method string              getStage()                          Returns the current record's "stage" value
 * @method string              getStat()                           Returns the current record's "stat" value
 * @method string              getSocialStatus()                   Returns the current record's "social_status" value
 * @method string              getRockForm()                       Returns the current record's "rock_form" value
 * @method integer             getSpecimenIndividualsCountMin()    Returns the current record's "specimen_individuals_count_min" value
 * @method integer             getSpecimenIndividualsCountMax()    Returns the current record's "specimen_individuals_count_max" value
 * @method Specimens           getSpecimens()                      Returns the current record's "Specimens" value
 * @method Doctrine_Collection getSpecimenParts()                  Returns the current record's "SpecimenParts" collection
 * @method SpecimenIndividuals setId()                             Sets the current record's "id" value
 * @method SpecimenIndividuals setSpecimenRef()                    Sets the current record's "specimen_ref" value
 * @method SpecimenIndividuals setType()                           Sets the current record's "type" value
 * @method SpecimenIndividuals setTypeGroup()                      Sets the current record's "type_group" value
 * @method SpecimenIndividuals setTypeSearch()                     Sets the current record's "type_search" value
 * @method SpecimenIndividuals setSex()                            Sets the current record's "sex" value
 * @method SpecimenIndividuals setStage()                          Sets the current record's "stage" value
 * @method SpecimenIndividuals setStat()                           Sets the current record's "stat" value
 * @method SpecimenIndividuals setSocialStatus()                   Sets the current record's "social_status" value
 * @method SpecimenIndividuals setRockForm()                       Sets the current record's "rock_form" value
 * @method SpecimenIndividuals setSpecimenIndividualsCountMin()    Sets the current record's "specimen_individuals_count_min" value
 * @method SpecimenIndividuals setSpecimenIndividualsCountMax()    Sets the current record's "specimen_individuals_count_max" value
 * @method SpecimenIndividuals setSpecimens()                      Sets the current record's "Specimens" value
 * @method SpecimenIndividuals setSpecimenParts()                  Sets the current record's "SpecimenParts" collection
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseSpecimenIndividuals extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('specimen_individuals');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('specimen_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('type', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'specimen',
             ));
        $this->hasColumn('type_group', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('type_search', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('sex', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'undefined',
             ));
        $this->hasColumn('stage', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'undefined',
             ));
        $this->hasColumn('stat', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'not applicable',
             ));
        $this->hasColumn('social_status', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'not applicable',
             ));
        $this->hasColumn('rock_form', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'not applicable',
             ));
        $this->hasColumn('specimen_individuals_count_min', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('specimen_individuals_count_max', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Specimens', array(
             'local' => 'specimen_ref',
             'foreign' => 'id'));

        $this->hasMany('SpecimenParts', array(
             'local' => 'id',
             'foreign' => 'specimen_individual_ref'));
    }
}