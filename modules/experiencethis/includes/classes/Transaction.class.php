<?php
require_once "BaseTransaction.class.php";

class Transaction extends BaseTransaction {
  static function findAllByLeadId($lid) {
    global $mysqli;
    $query = "SELECT * FROM transaction WHERE lead_id=$lid";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Transaction();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  public function getTicket() {
    global $mysqli;
    $query = 'SELECT * FROM et_ticket WHERE id=' . $this->getTicketId();
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new EtTicket();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
}
