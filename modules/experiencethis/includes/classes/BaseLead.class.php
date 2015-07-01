<?php
include_once MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'classes' . DS . 'DBObject.class.php';

/**
 * DB fields
 * - id
 * - email
 * - wechat_id
 * - ticket_type
 * - ticket_num
 * - created_at
 * - processed
 * - processed_at
 */
class BaseLead extends DBObject {
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
    $this->table_name = 'lead';
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
   public function setEmail($var) {
     $this->setDbFieldEmail($var);
   }
   public function getEmail() {
     return $this->getDbFieldEmail();
   }
   public function setWechatId($var) {
     $this->setDbFieldWechat_id($var);
   }
   public function getWechatId() {
     return $this->getDbFieldWechat_id();
   }
   public function setTicketType($var) {
     $this->setDbFieldTicket_type($var);
   }
   public function getTicketType() {
     return $this->getDbFieldTicket_type();
   }
   public function setTicketNum($var) {
     $this->setDbFieldTicket_num($var);
   }
   public function getTicketNum() {
     return $this->getDbFieldTicket_num();
   }
   public function setCreatedAt($var) {
     $this->setDbFieldCreated_at($var);
   }
   public function getCreatedAt() {
     return $this->getDbFieldCreated_at();
   }
   public function setProcessed($var) {
     $this->setDbFieldProcessed($var);
   }
   public function getProcessed() {
     return $this->getDbFieldProcessed();
   }
   public function setProcessedAt($var) {
     $this->setDbFieldProcessed_at($var);
   }
   public function getProcessedAt() {
     return $this->getDbFieldProcessed_at();
   }

  
  
  /**
   * self functions
   */
  static function dropTable() {
    return parent::dropTableByName('lead');
  }
  
  static function tableExist() {
    return parent::tableExistByName('lead');
  }
  
  static function createTableIfNotExist() {
    global $mysqli;

    if (!self::tableExist()) {
      return $mysqli->query('
CREATE TABLE IF NOT EXISTS `lead` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(128) ,
  `wechat_id` VARCHAR(32) ,
  `ticket_type` TINYINT(1) ,
  `ticket_num` TINYINT ,
  `created_at` INT ,
  `processed` TINYINT(1) DEFAULT 0 ,
  `processed_at` INT ,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;
      ');
    }
    
    return true;
  }
  
  static function findById($id, $instance = 'Lead') {
    global $mysqli;
    $query = 'SELECT * FROM lead WHERE id=' . $id;
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
    $query = "SELECT * FROM lead";
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Lead();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function findAllWithPage($page, $entries_per_page) {
    global $mysqli;
    $query = "SELECT * FROM lead LIMIT " . ($page - 1) * $entries_per_page . ", " . $entries_per_page;
    $result = $mysqli->query($query);
    
    $rtn = array();
    while ($result && $b = $result->fetch_object()) {
      $obj= new Lead();
      DBObject::importQueryResultToDbObject($b, $obj);
      $rtn[] = $obj;
    }
    
    return $rtn;
  }
  
  static function countAll() {
    global $mysqli;
    $query = "SELECT COUNT(*) as 'count' FROM lead";
    if ($result = $mysqli->query($query)) {
      return $result->fetch_object()->count;
    }
  }
  
  static function truncate() {
    global $mysqli;
    $query = "TRUNCATE TABLE lead";
    return $mysqli->query($query);
  }
}