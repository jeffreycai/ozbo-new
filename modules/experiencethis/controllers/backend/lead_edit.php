<?php

$id = isset($vars[1]) ? $vars[1] : null;
$object = Lead::findById($id);
if (is_null($object)) {
  HTML::forward('core/404');
}

// handle form submission
if (isset($_POST['submit'])) {
  $error_flag = false;

  /// validation
  
  // validation for $email
  $email = isset($_POST["email"]) ? strip_tags($_POST["email"]) : null;
  $retype_email = isset($_POST["retype_email"]) ? strip_tags($_POST["retype_email"]) : null;
  if (empty($email)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "email is required.", "zh" => "请填写email"))));
    $error_flag = true;
  }

  if ($email != $retype_email) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "Retype value does not match for email", "zh" => "再次输入的email与原值不匹配"))));
    $error_flag = true;
  }
  
  // validation for $wechat_id
  $wechat_id = isset($_POST["wechat_id"]) ? strip_tags($_POST["wechat_id"]) : null;  
  // validation for $ticket_type
  $ticket_type = isset($_POST["ticket_type"]) ? strip_tags($_POST["ticket_type"]) : null;
  if (empty($ticket_type)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "ticket_type is required.", "zh" => "请填写ticket_type"))));
    $error_flag = true;
  }
  
  // validation for $ticket_num
  $ticket_num = isset($_POST["ticket_num"]) ? strip_tags($_POST["ticket_num"]) : null;
  if (empty($ticket_num)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "ticket_num is required.", "zh" => "请填写ticket_num"))));
    $error_flag = true;
  }
  
  // validation for $created_at
  $created_at = isset($_POST["created_at"]) ? strip_tags($_POST["created_at"]) : null;  
  // validation for $processed
  $processed = isset($_POST["processed"]) ? 1 : 0;  
  // validation for $processed_at
  $processed_at = isset($_POST["processed_at"]) ? strip_tags($_POST["processed_at"]) : null;  /// proceed submission
  
  // proceed for $email
  $object->setEmail($email);
  
  // proceed for $wechat_id
  $object->setWechatId($wechat_id);
  
  // proceed for $ticket_type
  if (!empty($ticket_type)) {
    $object->setTicketType($ticket_type);
  }
  
  // proceed for $ticket_num
  if (!empty($ticket_num)) {
    $object->setTicketNum($ticket_num);
  }
  
  // proceed for $created_at
  $object->setCreatedAt($created_at);
  
  // proceed for $processed
  $object->setProcessed($processed);
  
  // proceed for $processed_at
  $object->setProcessedAt($processed_at);
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
  'en' => 'Edit Lead',
  'zh' => 'Edit 订单',
  )),
));
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('experiencethis/backend/lead_edit', array(
  'object' => $object
));


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

