<?php
  //-- EtTicket:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "experiencethis") {
      echo " - Drop table 'et_ticket' ";
      echo EtTicket::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- EtTicket:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "et_ticket") ) {
  //- create tables if not exits
  echo " - Create table 'et_ticket' ";
  echo EtTicket::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  
  //-- Lead:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "experiencethis") {
      echo " - Drop table 'lead' ";
      echo Lead::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- Lead:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "lead") ) {
  //- create tables if not exits
  echo " - Create table 'lead' ";
  echo Lead::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  
  //-- Transaction:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "experiencethis") {
      echo " - Drop table 'transaction' ";
      echo Transaction::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- Transaction:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "transaction") ) {
  //- create tables if not exits
  echo " - Create table 'transaction' ";
  echo Transaction::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  