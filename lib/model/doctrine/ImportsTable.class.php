<?php

/**
 * ImportsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class ImportsTable extends Doctrine_Table
{
  /**
    * Returns an instance of this class.
    *
    * @return object ImportsTable
    */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('Imports');
  }

  public function markOk($id)
  {
    $q = Doctrine_Query::create()->update('staging s');
    $q->andwhere('import_ref = ? ',$id)
      ->andWhere("status = ?",'')
      ->set('to_import', '?',true)
      ->execute();
    $q = Doctrine_Query::create()->update('Imports');
    $q->andwhere('id = ? ',$id)
      ->set('state', '?','processing')
      ->execute();
  }

  public function getNumberOfLines($record_ids)
  {
    if(! count($record_ids)) return array();
    $conn = Doctrine_Manager::connection();
    $sql = "select import_ref as id, count(*) as cnt FROM staging r where import_ref in (".implode(',',$record_ids).") GROUP BY import_ref";
    $result = $conn->fetchAssoc($sql);
    return $result;
  }

  public function clearImport($id)
  {

    $q = Doctrine_Query::create()->Delete('staging s')
      ->andwhere('import_ref = ? ',$id)
      ->execute();
    $q = Doctrine_Query::create()->update('Imports')
      ->andwhere('id = ? ',$id)
      ->set('state', '?','finished')
      ->set('is_finished', '?',true)
      ->execute();
  }

  public function getWithImports()
  {
    $q = Doctrine_Query::create()
      ->From('Imports i')
      ->andwhere('exists(select 1 from staging where to_import = true and import_ref = i.id)')
      ->andWhere("state = 'processing'");

    return $q->execute();
  }
}