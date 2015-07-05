<?php
$html = new HTML();

$html->renderOut('site/html_header', array(
    'body_class' => 'payment-result',
    'title' => i18n(array(
        'en' => 'Your payment failed',
        'zh' => '您的支付失败了'
    )) . " :: " . $settings['sitename']
));
//$html->renderOut('site/header');
$html->renderOut('site/payment_failed');
$html->renderOut('site/footer');
$html->renderOut('site/html_footer');