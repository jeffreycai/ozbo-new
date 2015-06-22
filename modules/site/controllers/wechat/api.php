<?php
// get vars from wechat request sent via GET
$signature = isset($_GET['signature']) ? $_GET['signature'] : null;
$timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : null;
$nonce = isset($_GET['nonce']) ? $_GET['nonce'] : null;
$echostr = isset($_GET['echostr']) ? $_GET['echostr'] : null;

$token = $settings['wechat_api']['token'];

if(wechat_check_signature($signature, $timestamp, $nonce, $token)) {
  echo $echostr;
}