<?php

/**
 * BaseAssociatedMultimedia
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $referenced_relation
 * @property integer $record_id
 * @property integer $multimedia_ref
 * @property Multimedia $Multimedia
 * 
 * @method integer              getId()                  Returns the current record's "id" value
 * @method string               getReferencedRelation()  Returns the current record's "referenced_relation" value
 * @method integer              getRecordId()            Returns the current record's "record_id" value
 * @method integer              getMultimediaRef()       Returns the current record's "multimedia_ref" value
 * @method Multimedia           getMultimedia()          Returns the current record's "Multimedia" value
 * @method AssociatedMultimedia setId()                  Sets the current record's "id" value
 * @method AssociatedMultimedia setReferencedRelation()  Sets the current record's "referenced_relation" value
 * @method AssociatedMultimedia setRecordId()            Sets the current record's "record_id" value
 * @method AssociatedMultimedia setMultimediaRef()       Sets the current record's "multimedia_ref" value
 * @method AssociatedMultimedia setMultimedia()          Sets the current record's "Multimedia" value
 * 
 * @package    darwin
 * @subpackage model
 * @author     DB team <collections@naturalsciences.be>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAssociatedMultimedia extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('associated_multimedia');
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
        $this->hasColumn('multimedia_ref', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Multimedia', array(
             'local' => 'multimedia_ref',
             'foreign' => 'id'));
    }
}