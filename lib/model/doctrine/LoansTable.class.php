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

    $status_group = LoanStatus::getClosedStatus('closed');
    $status_group_params = implode(',',array_fill(0,count($status_group),'?'));

    $q = Doctrine_Query::create()
      ->from('Loans l')
      ->where('EXISTS (SELECT lr.id FROM LoanRights lr WHERE lr.loan_ref = l.id AND lr.user_ref = ? )', $user_id)
      ->andWhere("EXISTS (SELECT ls.id FROM LoanStatus ls WHERE loan_ref = l.id AND ls.status NOT IN (". $status_group_params.") AND is_last = TRUE )", $status_group)
      ->orderBy('l.from_date desc');
      if( $max_items )
        $q->limit($max_items);

    return $q;
  }


  /*
   * Make a snapshot of the loans informations into the loans_history table
   * @param int $id Identifier of the loan concerned
   */
  public function syncHistory($id) {
    $conn = Doctrine_Manager::connection();
    $conn->exec("SELECT fct_cpy_loan_history(?)", array(intval($id)));
  }

  public function fetchHistories($id) {
    $conn_MGR = Doctrine_Manager::connection();
    $conn = $conn_MGR->getDbh();
    $statement = $conn->prepare('SELECT loan_ref,
                                        count(*) as items,
                                        modification_date_time as date
                                  FROM loan_history
                                  WHERE loan_ref = :id
                                  GROUP BY loan_ref, modification_date_time
                                  ORDER BY modification_date_time desc'
    );
    $statement->execute(array(':id' => $id));
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }

  public function findLoaned($part_id) {
    $q = Doctrine_Query::create()
      ->from('Loans l')
      ->andWhere("EXISTS (SELECT ls.id FROM LoanStatus ls WHERE loan_ref = l.id AND ls.status IN ('running', 'extended') AND is_last = TRUE )")
      ->andWhere('EXISTS (SELECT li.id FROM LoanItems li WHERE li.loan_ref = l.id AND li.specimen_ref = ? )', $part_id);
    return $q->execute();
  }

  public function getRelatedToSpecimen($id) {
    $q = Doctrine_Query::create()
      ->from('Loans l')
      ->innerJoin('l.LoanStatus')
      ->andWhere('EXISTS (SELECT li.id FROM LoanItems li WHERE li.loan_ref = l.id AND li.specimen_ref = ? )', $id);
    return $q->execute();
  }

  /**
   * Used for autocompletion in widgetFormSelectComplete
   * @param $user object The user that serves at filtering the list of loans we can get access to
   * @param $needle string The string already entered
   * @param $exact boolean Indicates if an exact match has to be performed
   * @param $limit integer The limit number of records to be retrieved
   */
  public function completeAsArray($user, $needle, $exact, $limit = 30, $level)
  {
    $conn_MGR = Doctrine_Manager::connection();
    $q = Doctrine_Query::create()
                       ->select('loa.id as id, loa.name as name, fullToIndex(loa.name) as name_indexed')
                       ->from('Loans loa')
                       ->orderBy('name ASC')
    ;
    if($exact)
      $q->andWhere("name = ?",$needle);
    else
      $q->andWhere("fullToIndex(name) like concat('%',fulltoindex(".$conn_MGR->quote($needle, 'string')."),'%') ");

    if($user && ! $user->isA(Users::ADMIN) ) {
      $q->innerJoin('loa.LoanRights r ON loa.id = r.loan_ref AND r.user_ref = ?', $user->getId());
    }

    $q_results = $q->execute();
    $result = array();
    foreach($q_results as $item) {
      $result[] = array('label' => $item->getName(), 'name_indexed'=> $item->getNameIndexed(), 'value'=> $item->getId() );
    }
    return $result;
  }

  /**
   * Used for duplication of loans / replace the classic approach used so far
   * @param $loan_id integer The id of the loan we wish to duplicate
   * @return integer id of new loan created
   */
  public function duplicateLoan($loan_id) {
    $conn_MGR = Doctrine_Manager::connection();
    $conn_MGR->getDbh()->exec('BEGIN TRANSACTION;');
    $id = $conn_MGR->fetchOne('SELECT fct_duplicate_loans(:loan_id)', array(':loan_id'=>$loan_id));
    if( $id != 0) {
      $conn_MGR->getDbh()->exec('COMMIT;');
    }
    else {
      $conn_MGR->getDbh()->exec('ROLLBACK;');
    }
    return $id;
  }

  /**
   * List of printable loans out of a list of loans
   * A printable loan is defined by having at least one contact point on the receiver side
   * and by having at least one item
   * @param $paged_loan_list array prefiltered list of loans coming from the pager or from the print call
   * @param $user object User to bring on the loan rights table
   * @return array list of loan ids that can be printed
   */
  public function getPrintableLoans($paged_loan_list, $user) {
    if ( $user->isA(Users::ADMIN) ) {
      return $paged_loan_list;
    }
    $q = Doctrine_Query::create()
      ->select('l.id')
      ->from('Loans l')
      ->innerJoin('l.LoanRights lr')
      ->innerJoin('l.LoanItems li')
      ->innerJoin("l.CataloguePeople cp")
      ->where('cp.people_type = ?', array('receiver'))
      ->andwhereIn('l.id', $paged_loan_list)
      ->andWhere('lr.user_ref = ?', array($user->getId()))
      ->distinct(true);
    $results = $q->fetchArray();
    $response = array();
    foreach ( $results as $loans ) {
      $response[] = $loans['id'];
    }
    return $response;
  }

  /**
   * Get the list of related loans for given specimen(s) id(s)
   * @param myUser $user object The user that serves at filtering the list of loans we can get access to
   * @param null $specId Specimen(s) Id(s)
   * @return \Doctrine_Collection
   */
  public function getLoansRelated($user, $specId = null)
  {
    return $this->getLoansRelatedArray($user, $specId);
  }

  /**
   * Get all loans related to an Array of id
   * @param myUser $user object The user that serves at filtering the list of loans we can get access to
   * @param array $specIds Array of id of related record
   * @return Doctrine_Collection Collection of loans
   */
  public function getLoansRelatedArray($user, $specIds = array())
  {
    $specimenIds = '';
    if(is_array($specIds)) {
      if(empty($specIds) || count($specIds) === 0) return array();
      $specimenIds = implode(',', $specIds);
    }
    else {
      $specimenIds = $specIds;
    }
    $conn_MGR = Doctrine_Manager::connection();
    $conn = $conn_MGR->getDbh();
    $sql = "select li.specimen_ref as specimen_id,
                   count(distinct li.loan_ref) as loans_count,
                   array_to_string(array_agg(li.loan_ref), CHR(10)) as loans_ref,
                   array_to_string(array_agg((select name from loans where id = li.loan_ref)), CHR(10)) as loans_name,
                   array_to_string(array_agg((select status from loan_status as ls where ls.loan_ref = li.loan_ref and ls.is_last = true limit 1)), CHR(10)) as loans_status
            from loan_items as li ";
    $sqlWhere = "where li.specimen_ref  = any('{ $specimenIds }'::int[])";
    $sqlGroupAndOrderBy = " group by li.specimen_ref
                            order by li.specimen_ref";
    $params = array();
    if (!$user->isA(Users::ADMIN)) {
      $sql .= " inner join loan_rights as lr on li.loan_ref = lr.loan_ref";
      $sqlWhere .= " and lr.user_ref = case when :user_id = 0 then lr.user_ref else :user_id end";
      $params[':user_id'] = $user->getId();
    }

    $sql .= $sqlWhere.$sqlGroupAndOrderBy;
    $statement = $conn->prepare($sql);
    $statement->execute($params);
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $results;
  }

}
