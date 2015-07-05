<?php
$ticket;
$ticket_num;
$ticket_idx;
if (isset($_REQUEST['submit'])) {
  $ticket = $settings['ticket_type'][$_GET['ticket_idx']];
  $ticket_num = $_GET['ticket_num'];
  $ticket_idx = $_GET['ticket_idx'];
} else {
  die('Direct access is not allowed');
}

$html = new HTML();
$html->renderOut('site/html_header', array(
    'body_class' => 'details',
    'title' => $settings['sitename'] . " :: 订单详情"
));
//$html->renderOut('site/header');
$html->renderOut('site/details', array(
    'ticket' => $ticket,
    'ticket_num' => $ticket_num,
    'ticket_idx' => $ticket_idx
));
$html->renderOut('site/html_footer');