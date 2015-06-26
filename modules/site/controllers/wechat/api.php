<?php
// get vars from wechat request sent via GET
$signature = isset($_GET['signature']) ? $_GET['signature'] : null;
$timestamp = isset($_GET['timestamp']) ? $_GET['timestamp'] : null;
$nonce = isset($_GET['nonce']) ? $_GET['nonce'] : null;
$echostr = isset($_GET['echostr']) ? $_GET['echostr'] : null;

$token = $settings['wechat_api']['token'];

if(wechat_check_signature($signature, $timestamp, $nonce, $token)) {
  load_library_wechat_sdk();

  $options = array(
      'token' => $settings['wechat_api']['token'],
      'encodingaeskey' => $settings['wechat_api']['encoding_aes_key'],
      'appid' => $settings['wechat_api']['appid'],
      'appsecret' => $settings['wechat_api']['appsecret']
  );
  $wechat = new Wechat($options);

  $wechat->valid();
  $type = $wechat->getRev()->getRevType();
  switch ($type) {
    case Wechat::MSGTYPE_TEXT:
      $uid = $wechat->getRevTo();
      $wechat->text($wechat->getUserInfo($uid))->reply();
      exit;
      break;
    case Wechat::MSGTYPE_EVENT:
      $event = $wechat->getRevEvent();
      $wechat->text($event['key'])->reply();
      break;
    case Wechat::MSGTYPE_IMAGE:
      break;
    default:
      $wechat->text("help info")->reply();
  }
}


