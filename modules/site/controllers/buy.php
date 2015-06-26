<?php

$html = new HTML();
$html->renderOut('site/html_header', array(
    'body_class' => 'buy',
    'title' => $settings['sitename'] . " :: 购买电影票"
));

$html->renderOut('site/html_footer');