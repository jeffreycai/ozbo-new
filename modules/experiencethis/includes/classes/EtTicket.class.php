<?php
require_once "BaseEtTicket.class.php";

class EtTicket extends BaseEtTicket {
  const TYPE_ADULT_ESAVER = 1;
  const TYPE_EMOVIE = 2;
  const TYPE_CHILD_ESAVER = 3;
  
  static function findByUrl($url, $instance = 'EtTicket') {
    global $mysqli;
    $query = 'SELECT * FROM et_ticket WHERE url=' . DBObject::prepare_val_for_sql($url);
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new $instance();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  static function findAllUnsoldByType($type) {
    global $mysqli;
    $query = "SELECT * FROM et_ticket WHERE ticket_type=$type AND (sent_at IS NULL OR sent_at=0)";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new EtTicket();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  public function getDownloadUrl() {
    return uri('admin/et_ticket/download/' . $this->getId());
  }
  
  public function delete() {
    // delete the ticket pdf file
    $this->deleteTicketFile();
    
    return parent::delete();
  }
  
  public function deleteTicketFile() {
    if (is_file(TICKET_DIR . DS . $this->getLocalPath())) {
      unlink(TICKET_DIR . DS . $this->getLocalPath());
    }
  }
}
