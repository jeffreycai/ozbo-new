<?php

wechat_access_only();

$ticket;
$ticket_idx;
$ticket_num;
$email;
if (isset($_REQUEST['submit'])) {
  $ticket = $settings['ticket_type'][$_GET['ticket_idx']];
  $ticket_idx = $_GET['ticket_idx'];
  $ticket_num = $_GET['ticket_num'];
  $email = $_GET['email'];
  $email_confirm = $_GET['email_confirm'];
  
  if ($email != $email_confirm) {
    Message::register(new Message(Message::DANGER, '邮件地址和确认地址不符，请检查'));
    HTML::forwardBackToReferer();
  } else if (!preg_match('/^[^@]+@[^\.@]+\..+$/', $email)) {
    Message::register(new Message(Message::DANGER, '邮件地址不合法，请检查'));
    HTML::forwardBackToReferer();
  } else if (preg_match('/qq\.com/', $email)) {
    Message::register(new Message(Message::DANGER, '您好，我们暂不支持QQ邮箱。请选用其他邮箱，谢谢'));
    HTML::forwardBackToReferer();
  }
} else {
  die('Direct access is not allowed');
}

$html = new HTML();
$html->renderOut('site/html_header', array(
    'body_class' => 'pay',
    'title' => $settings['sitename'] . " :: 支付"
));
//$html->renderOut('site/header');
$html->renderOut('site/pay', array(
    'ticket' => $ticket,
    'ticket_num' => $ticket_num,
    'ticket_idx' => $ticket_idx,
    'email' => $email
));
$html->renderOut('site/footer');
$html->renderOut('site/html_footer');