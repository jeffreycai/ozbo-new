<?php

$id = isset($vars[1]) ? $vars[1] : null;

$lead = Lead::findById($id);
$ticket_num = $lead->getTicketNum();
$ticket_idx = $lead->getTicketType();
$ticket = $settings['ticket_type'][$ticket_idx];
$email = $lead->getEmail();

// if the lead has been processed, we just resend the emails
if ($lead->getProcessed()) {
  $transactions = Transaction::findAllByLeadId($lead->getId());
  $tickets_to_send = array();
  foreach ($transactions as $t) {
    $tickets_to_send[] = TICKET_DIR . DS . $t->getTicket()->getLocalPath();
  }
  // send tickets
  $email_template = load_fixture('site', 'email.yml');
  $html = new HTML();
  $details = $html->render('site/components/order_details', array(
      'ticket' => $ticket,
      'ticket_num' => $ticket_num
  ));
  sendTicketToClient($email_template['confirm']['subject'], $email_template['confirm']['content'] . $details, $tickets_to_send, $email);
  Message::register(new Message(Message::SUCCESS, 'Successfully resend ' . $ticket_num . ' tickets to ' . $email));
  HTML::forwardBackToReferer();

// if the lead has not been processed
} else {

  $tickets = EtTicket::findAllUnsoldByType($ticket_idx);

// when running out of stock, send alert
  if (sizeof($tickets) < $ticket_num) {
    $msg = 'Not enough stock for ticket type - ' . $ticket['name'] . '. <br />Asked for ' . $ticket_num . ', stock is ' . sizeof($tickets) . ' <br />LeadID: ' . $lead->getId() . '. <br />NOT PROCEEDED! Please mannually do it.';
    Message::register(new Message(Message::DANGER, $msg));
    HTML::forwardBackToReferer();
    // otherwise, send tickets to client
  } else {
    // send warning when stock is low
    if (sizeof($tickets) - $ticket_num < $settings['stock_warning_threshold']) {
      $msg = 'Stock running low for ticket type - ' . $ticket['name'] . '. <br />Remaining stock number is ' . (sizeof($tickets) - $ticket_num) . '. <br />Please purchase more.';
      Message::register(new Message(Message::WARNING, $msg));
    }
    // prepare the tickets to send
    $tickets_to_send = array();
    for ($i = 0; $i < $ticket_num; $i++) {
      $t = $tickets[$i];
      $t->setSentAt(time());
      $t->setLeadId($lead->getId());
      $t->save();
      $tickets_to_send[] = TICKET_DIR . DS . $t->getLocalPath();
    }
    // send tickets
    $email_template = load_fixture('site', 'email.yml');
    $html = new HTML();
    $details = $html->render('site/components/order_details', array(
        'ticket' => $ticket,
        'ticket_num' => $ticket_num
    ));
    sendTicketToClient($email_template['confirm']['subject'], $email_template['confirm']['content'] . $details, $tickets_to_send, $email);
    // set transaction
    for ($i = 0; $i < $ticket_num; $i++) {
      $transaction = new Transaction();
      $transaction->setGrossProfit($ticket['margin']);
      $transaction->setLeadId($lead->getId());
      $transaction->setPayment($ticket['cost'] + $ticket['margin']);
      $transaction->setTicketId($tickets[$i]->getId());
      $transaction->setTimestamp(time());
      $transaction->save();
    }
    // update lead
    $lead = Lead::findById($lead->getId());
    $lead->setProcessed(1);
    $lead->setProcessedAt(time());
    $lead->save();
    
    Message::register(new Message(Message::SUCCESS, $ticket_num . ' tickets successfully sent to ' . $email));
    HTML::forwardBackToReferer();
  }
}


