<?php

/**
 * LoansTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LoansTable extends DarwinTable
{
  /**
   * Returns an instance of this class.
   *
   * @return object LoansTable
   */
  
  public static function getInstance()
  {
    return Doctrine_Core::getTable('Loans');
  }


  /**
  * getMyLoans
  *
  * Get the loans for a user that are not Closed/Returned/Rejected
  *
  * @param int $user_id The user id to look for
  * @param int $max_items a number loans to get
  *
  * @return Doctrine_Query Query with loans ordered by from_date desc
  */

  public function getMyLoans($user_id, $max_items = FALSE) 
  {

    $status_group = array_values(loans::getStatusFromGroup('closed'));
    $status_group_params = implode(',',array_fill(0,count($status_group),'?'));

    $q = Doctrine_Query::create()
      ->select('l.*')
      ->from('Loans l')
      ->andWhere('EXISTS (SELECT * FROM LoanRights lr WHERE loan_ref = l.id AND lr.user_ref = ? )', $user_id)
      ->andWhere("EXISTS (SELECT * FROM LoanStatus ls WHERE loan_ref = l.id AND ls.status NOT IN (". $status_group_params.") AND is_last = TRUE )", $status_group)
      ->orderBy('l.from_date desc');
      if( $max_items )
	$q->limit($max_items);

    return $q;
  }

}