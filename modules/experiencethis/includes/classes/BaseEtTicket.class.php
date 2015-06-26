<?php
include_once MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'classes' . DS . 'DBObject.class.php';

/**
 * DB fields
 * - id
 * - url
 * - local_path
 * - ticket_type
 * - cost
 * - sent_at
 * - created_at
 */
class BaseEtTicket extends DBObject {
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
    $this->table_name = 'et_ticket';
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
   public function setUrl($var) {
     $this->setDbFieldUrl($var);
   }
   public function getUrl() {
     return $this->getDbFieldUrl();
   }
   public function setLocalPath($var) {
     $this->setDbFieldLocal_path($var);
   }
   public function getLocalPath() {
     return $this->getDbFieldLocal_path();
   }
   public function setTicketType($var) {
     $this->setDbFieldTicket_type($var);
   }
   public function getTicketType() {
     return $this->getDbFieldTicket_type();
   }
   public function setCost($var) {
     $this->setDbFieldCost($var);
   }
   public function getCost() {
     return $this->getDbFieldCost();
   }
   public function setSentAt($var) {
     $this->setDbFieldSent_at($var);
   }
   public function getSentAt() {
     return $this->getDbFieldSent_at();
   }
   public function setCreatedAt($var) {
     $this->setDbFieldCreated_at($var);
   }
   public function getCreatedAt() {
     return $this->getDbFieldCreated_at();
   }

  
  
  /**
   * self functions
   */
  static function dropTable() {
    return parent::dropTableByName('et_ticket');
  }
  
  static function tableExist() {
    return parent::tableExistByName('et_ticket');
  }
  
  static function createTableIfNotExist() {
    global $mysqli;

    if (!self::tableExist()) {
      return $mysqli->query('
CREATE TABLE IF NOT EXISTS `et_ticket` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `url` VARCHAR(256) NOT NULL ,
  `local_path` VARCHAR(20) ,
  `ticket_type` TINYINT(1) ,
  `cost` FLOAT ,
  `sent_at` INT DEFAULT NULL ,
  `created_at` INT ,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
      ');
    }
    
    return true;
  }
  
  static function findById($id, $instance = 'EtTicket') {
    global $mysqli;
    $query = 'SELECT * FROM et_ticket WHERE id=' . $id;
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
    $query = "SELECT * FROM et_ticket";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new EtTicket();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function findAllWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM et_ticket LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new EtTicket();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function countAll() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM et_ticket";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function truncate() {
    global $mysqli;
    $query = "TRUNCATE TABLE et_ticket";
    return $mysqli->query($query);
  }
}