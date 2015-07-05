<?php

$html = new HTML();
$html->renderOut('site/html_header', array(
    'body_class' => 'order',
    'title' => $settings['sitename'] . " :: 购买电影票"
));
//$html->renderOut('site/header', array('active_url' => array('/order')));
$html->renderOut('site/order');
$html->renderOut('site/footer');
$html->renderOut('site/html_footer');