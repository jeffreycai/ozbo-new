<?php

$tid = isset($vars[1]) ? $vars[1] : null;
$ticket = EtTicket::findById($tid);

if (!$ticket) {
  die('Can not find this ticket');
}

$path = TICKET_DIR . DS . $ticket->getLocalPath();

header("Content-type:application/pdf");
header("Content-Disposition:attachment;filename=".$ticket->getLocalPath());

readfile($path);