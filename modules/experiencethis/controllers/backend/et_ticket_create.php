<?php

$object = new EtTicket();
  
// handle form submission
if (isset($_POST['submit'])) {
  $error_flag = false;

  /// validation
  
  // validation for $url
  $url = isset($_POST["url"]) ? strip_tags($_POST["url"]) : null;
  if (empty($url)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "url is required.", "zh" => "请填写url"))));
    $error_flag = true;
  }

  if (strlen($url) >= 256) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "Max length for url is 256", "zh" => "url 不能超过256个字符"))));
    $error_flag = true;
  }
  
  // validation for $local_path
  $local_path = isset($_POST["local_path"]) ? strip_tags($_POST["local_path"]) : null;  
  // validation for $ticket_type
  $ticket_type = isset($_POST["ticket_type"]) ? strip_tags($_POST["ticket_type"]) : null;
  if (empty($ticket_type)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "ticket_type is required.", "zh" => "请填写ticket_type"))));
    $error_flag = true;
  }
  
  // validation for $cost
  $cost = isset($_POST["cost"]) ? strip_tags($_POST["cost"]) : null;
  if (empty($cost)) {
    Message::register(new Message(Message::DANGER, i18n(array("en" => "cost is required.", "zh" => "请填写cost"))));
    $error_flag = true;
  }
  
  // validation for $sent_at
  $sent_at = isset($_POST["sent_at"]) ? strip_tags($_POST["sent_at"]) : null;  
  // validation for $created_at
  $created_at = isset($_POST["created_at"]) ? strip_tags($_POST["created_at"]) : null;  /// proceed submission
  
  // proceed for $url
  $object->setUrl($url);
  
  // proceed for $local_path
  $object->setLocalPath($local_path);
  
  // proceed for $ticket_type
  if (!empty($ticket_type)) {
    $object->setTicketType($ticket_type);
  }
  
  // proceed for $cost
  $object->setCost($cost);
  
  // proceed for $sent_at
  $object->setSentAt($sent_at);
  
  // proceed for $created_at
  $object->setCreatedAt($created_at);
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
  'en' => 'Create ExperienceThis Ticket',
  'zh' => 'Create ExperienceThis 电影票',
  )),
));
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('experiencethis/backend/et_ticket_create', array(
  'object' => $object
));


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

