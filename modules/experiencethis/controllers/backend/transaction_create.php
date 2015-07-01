<?php

$object = new Transaction();
  
// handle form submission
if (isset($_POST['submit'])) {
  $error_flag = false;

  /// validation
  
  // validation for $ticket_id
  $ticket_id = isset($_POST["ticket_id"]) ? strip_tags($_POST["ticket_id"]) : null;  
  // validation for $lead_id
  $lead_id = isset($_POST["lead_id"]) ? strip_tags($_POST["lead_id"]) : null;  
  // validation for $timestamp
  $timestamp = isset($_POST["timestamp"]) ? strip_tags($_POST["timestamp"]) : null;  
  // validation for $payment
  $payment = isset($_POST["payment"]) ? strip_tags($_POST["payment"]) : null;  
  // validation for $gross_profit
  $gross_profit = isset($_POST["gross_profit"]) ? strip_tags($_POST["gross_profit"]) : null;  /// proceed submission
  
  // proceed for $ticket_id
  $object->setTicketId($ticket_id);
  
  // proceed for $lead_id
  $object->setLeadId($lead_id);
  
  // proceed for $timestamp
  $object->setTimestamp($timestamp);
  
  // proceed for $payment
  $object->setPayment($payment);
  
  // proceed for $gross_profit
  $object->setGrossProfit($gross_profit);
  if ($error_flag == false) {
    if ($object->save()) {
      Message::register(new Message(Message::SUCCESS, i18n(array("en" => "Record saved", "zh" => "记录保存成功"))));
      HTML::forwardBackToReferer();
    } else {
      Message::register(new Message(Message::DANGER, i18n(array("en" => "Record failed to save", "zh" => "记录保存失败"))));
    }
  }
}



$html = new HTML();

$html->renderOut('core/backend/html_header', array(
  'title' => i18n(array(
  'en' => 'Create Transaction',
  'zh' => 'Create 交易',
  )),
));
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('experiencethis/backend/transaction_create', array(
  'object' => $object
));


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

