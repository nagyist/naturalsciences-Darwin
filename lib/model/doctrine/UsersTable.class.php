<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UsersTable extends DarwinTable
{
  /**
  * Find item for autocompletion
  * @param $user The User object for right management
  * @param $needle the string entered by the user for search
  * @param $exact bool are we searching the exact term or more or less fuzzy
  * @return Array of results
  */
  public function completeAsArray($user, $needle, $exact, $limit = 30, $level)
  {
    $conn_MGR = Doctrine_Manager::connection();
    $q = Doctrine_Query::create()
      ->from('Users')
      ->orderBy('formated_name ASC')
      ->limit($limit);
    if($exact)
      $q->andWhere("formated_name = ?",$needle);
    else
      $q->andWhere("formated_name_indexed like concat('%',fulltoindex(".$conn_MGR->quote($needle, 'string')."),'%') ");
    $q_results = $q->execute();
    $result = array();
    foreach($q_results as $item) {
      $result[] = array('label' => $item->getFormatedName(), 'value'=> $item->getId() );
    }
    return $result;
  }

  /**
  * Get a user with his username and password in internal system
  * @param string $username The username
  * @param string $password The password of the user
  * @return a record with the user or null if it's not found
  */
  public function getUserByPassword($username, $password)
  {
      $q = Doctrine_Query::create()
          ->useResultCache(null)
          ->from('Users u')
          ->leftJoin('u.UsersLoginInfos ul')
          ->andWhere('ul.user_name = ?',$username)
          ->andWhere('ul.password = ?',sha1(sfConfig::get('dw_salt').$password))
          ->andWhere('ul.login_system is null')
          ->andWhere('ul.login_type = ?', 'local');
      return $q->fetchOne();
  }

  public function getTrackingUsers()
  {
    $q = Doctrine_Query::create()
      ->from('Users u')
      //->innerJoin('u.UsersTracking t');
      ->where('exists( select user_ref from users_tracking where user_ref=u.id)');
    return $q->execute();
  }

  public function findUser($id)
  {
    $q = Doctrine_Query::create()
      ->from('users u')
      ->where('u.id = ?', $id);
    return $q->fetchOne(); 
  }
  
  public  function getManagerWithId($id)
  {
    $q = Doctrine_Query::create()
      ->from('users u')
      ->where('u.db_user_type >= 4')
      ->andwhere('u.id = ?', $id);

    return $q->fetchOne(); 
  }
  public function getDistinctTitle()
  {
      return $this->createFlatDistinct('users', 'title', 'title')->execute();
  }	
  
  public function getDistinctSubType()
  {
      return $this->createFlatDistinct('users', 'sub_type', 'sub_type')->execute();
  }

  public function getUserByLoginAndEMail($username, $email)
  {
    $q = Doctrine_Query::create()
          ->useResultCache(null)
          ->from('Users u')
          ->innerJoin('u.UsersLoginInfos ul')
          ->innerJoin('u.UsersComm uc')
          ->andWhere('ul.user_name = ?',$username)
          ->andWhere('ul.login_system is null')
          ->andWhere('ul.login_type = ?', 'local')
          ->andWhere('uc.comm_type = ?', 'e-mail')
          ->andWhere('lower(uc.entry) = lower(?)', $email);
    return $q->fetchOne();
  }

  public function getUserByLogin($username, $type='local')
  {
     $q = Doctrine_Query::create()
      ->useResultCache(null)
      ->from('Users u')
      ->innerJoin('u.UsersLoginInfos ul')
      ->andWhere('ul.user_name = ?',$username)
      ->andWhere('ul.login_system is null')
      ->andWhere('ul.login_type = ?', $type);
    return $q->fetchOne();
  }

  public function getUserByLoginWithEmailOnly($username, $type='local')
  {
     $q = Doctrine_Query::create()
          ->useResultCache(null)
          ->from('Users u')
          ->innerJoin('u.UsersLoginInfos ul')
          ->innerJoin('u.UsersComm uc')
          ->andWhere('ul.user_name = ?',$username)
          ->andWhere('ul.login_system is null')
          ->andWhere('ul.login_type = ?', $type)
          ->andWhere('uc.comm_type = ?', 'e-mail');
    return $q->fetchOne();
  }
}
