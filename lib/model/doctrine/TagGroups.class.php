<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class TagGroups extends BaseTagGroups
{
  private static $groups =  array(
      'administrative area' => 'Administrative area',
      'topographic' => 'Topographic structure',
      'hydrographic' => 'Hydrographic',
      'orography' => 'Orography',
      'spot' => 'Spot',
      'area' => 'Area',
      'historical' => 'Historical',
      'populated' => 'Populated Places',
      'underground' => 'Underground',
      'road' => 'Road',
      'vegetation' => 'Vegetation',
      'habitat' => 'Habitat',
      'other' => 'Other'
    );


  public static function getGroups()
  {
    try{
        $i18n_object = sfContext::getInstance()->getI18n();
    }
    catch( Exception $e )
    {
        return self::$groups;
    }
    return array_map(array($i18n_object, '__'), self::$groups);
  }  

  static public function getGroup($name)
  {
    $groups = self::getGroups();
    return $groups[$name];
  }
}
