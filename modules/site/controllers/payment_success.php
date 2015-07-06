<?php
wechat_access_only();

$lead_id = isset($_SESSION['lead_id']) ? $_SESSION['lead_id'] : false;
$lead;
        
if ($lead_id && $lead = Lead::findById($lead_id)) {
  $html = new HTML();

  $html->renderOut('site/html_header', array(
      'body_class' => 'payment-result',
      'title' => i18n(array(
          'en' => 'Your payment is successful',
          'zh' => '您的支付成功了！'
      )) . " :: " . $settings['sitename']
  ));
//  $html->renderOut('site/header');
  $html->renderOut('site/payment_success', array('lead' => $lead));
  $html->renderOut('site/footer');
  $html->renderOut('site/html_footer');
} else {
  HTML::forward('payment/failed');
}




