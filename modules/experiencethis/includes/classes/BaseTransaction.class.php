<?php
include_once MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'classes' . DS . 'DBObject.class.php';

/**
 * DB fields
 * - id
 * - ticket_id
 * - order_id
 * - timestamp
 * - payment
 * - gross_profit
 */
class BaseTransaction extends DBObject {
  /**
   * Implement parent abstract functions
   */
  protected function setPrimaryKeyName() {
    $this->primary_key = array(
      'id'
    );
  }
  protected function setPrimaryKeyAutoIncreased() {
    $this->pk_auto_increased = TRUE;
  }
  protected function setTableName() {
    $this->table_name = 'transaction';
  }
  
  /**
   * Setters and getters
   */
   public function setId($var) {
     $this->setDbFieldId($var);
   }
   public function getId() {
     return $this->getDbFieldId();
   }
   public function setTicketId($var) {
     $this->setDbFieldTicket_id($var);
   }
   public function getTicketId() {
     return $this->getDbFieldTicket_id();
   }
   public function setOrderId($var) {
     $this->setDbFieldOrder_id($var);
   }
   public function getOrderId() {
     return $this->getDbFieldOrder_id();
   }
   public function setTimestamp($var) {
     $this->setDbFieldTimestamp($var);
   }
   public function getTimestamp() {
     return $this->getDbFieldTimestamp();
   }
   public function setPayment($var) {
     $this->setDbFieldPayment($var);
   }
   public function getPayment() {
     return $this->getDbFieldPayment();
   }
   public function setGrossProfit($var) {
     $this->setDbFieldGross_profit($var);
   }
   public function getGrossProfit() {
     return $this->getDbFieldGross_profit();
   }

  
  
  /**
   * self functions
   */
  static function dropTable() {
    return parent::dropTableByName('transaction');
  }
  
  static function tableExist() {
    return parent::tableExistByName('transaction');
  }
  
  static function createTableIfNotExist() {
    global $mysqli;

    if (!self::tableExist()) {
      return $mysqli->query('
CREATE TABLE IF NOT EXISTS `transaction` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `ticket_id` INT ,
  `order_id` INT ,
  `timestamp` INT ,
  `payment` FLOAT ,
  `gross_profit` FLOAT ,
  PRIMARY KEY (`id`)
 ,
INDEX `fk-transaction-ticket_id-idx` (`ticket_id` ASC),
CONSTRAINT `fk-transaction-ticket_id`
  FOREIGN KEY (`ticket_id`)
  REFERENCES `et_ticket` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE ,
INDEX `fk-transaction-order_id-idx` (`order_id` ASC),
CONSTRAINT `fk-transaction-order_id`
  FOREIGN KEY (`order_id`)
  REFERENCES `order` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
      ');
    }
    
    return true;
  }
  
  static function findById($id, $instance = 'Transaction') {
    global $mysqli;
    $query = 'SELECT * FROM transaction WHERE id=' . $id;
    $result = $mysqli->query($query);
    if ($result && $b = $result->fetch_object()) {
      $obj = new $instance();
      DBObject::importQueryResultToDbObject($b, $obj);
      return $obj;
    }
    return null;
  }
  
  static function findAll() {
    global $mysqli;
    $query = "SELECT * FROM transaction";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Transaction();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function findAllWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM transaction LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Transaction();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function countAll() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM transaction";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function truncate() {
    global $mysqli;
    $query = "TRUNCATE TABLE transaction";
    return $mysqli->query($query);
  }
}