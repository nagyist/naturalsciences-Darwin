<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CataloguePropertiesTable extends DarwinTable
{
  /**
  * Find a property (joined with values)
  * for a given table and record id
  * @param string $table_name db table name
  * @param int $record_id id of the record
  * @return a Doctrine_collection of results
  */
  public function findForTable($table_name, $record_id)
  {
     $q = Doctrine_Query::create()
	 ->from('CatalogueProperties p')
	 ->leftJoin('p.PropertiesValues v')
	 ->orderBy('p.property_type ASC');
     $q = $this->addCatalogueReferences($q, $table_name, $record_id, 'p', true);
     return $q->execute();
  }

  /**
  * Get Distincts type of properties
  * @return array an Array of types in keys
  */
  public function getDistinctType($ref_relation)
  {
    return array_merge(array(''=>''), $this->createDistinctDepend('catalogue_properties', 'property_type' , 'referenced_relation', $ref_relation));
  }

  /**
  * Get Distincts Sub Type of properties
  * filter by type if one given
  * @param string $type a type
  * @return array an Array of sub-types in keys/values
  */
  public function getDistinctSubType($type)
  {
    return array_merge(array(''=>''), $this->createDistinctDepend('catalogue_properties', 'property_sub_type' , 'property_type', $type));
  }

  /**
  * Get Distincts Qualifier of properties
  * filter by sub type if one given
  * @param string $sub_type a type
  * @return array an Array of Qualifier in keys/values
  */
  public function getDistinctQualifier($sub_type)
  {
    return array_merge(array(''=>''), $this->createDistinctDepend('catalogue_properties', 'property_qualifier' , 'property_sub_type', $sub_type));
  }
  
  /**
  * Get Distincts units (accuracy + normal) of properties
  * filter by type if one given
  * @param string $type a type
  * @return array an Array of Qualifier in keys/values
  */
  public function getDistinctUnit($type)
  {
    $results_unit = $this->createDistinctDepend('catalogue_properties', 'property_unit' , 'property_type', $type);
    $results_accuracy = $this->createDistinctDepend('catalogue_properties', 'property_accuracy_unit' , 'property_type', $type);

    return array_merge(array(''=>'unit'), array_merge($results_unit, $results_accuracy));
  }
}
