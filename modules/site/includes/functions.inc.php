<?php

function wechat_check_signature($signature, $timestamp, $nonce, $token)
{
	$tmpArr = array($token, $timestamp, $nonce);
	sort($tmpArr, SORT_STRING);
	$tmpStr = implode( $tmpArr );
	$tmpStr = sha1( $tmpStr );
	
	if( $tmpStr == $signature ){
		return true;
	}else{
		return false;
	}
}


function wechat_access_only() {
  // we don't restric if it is dev
  if (ENV == 'dev') {
    return true;
  }
//print_r($_SERVER['HTTP_REFERER']);
  if (isset($_SESSION['wechat_access']) && $_SESSION['wechat_access'] == 1) {
    return true;
  } else if (isset($_COOKIE['wechat_access']) && $_COOKIE['wechat_access'] == 1) {
    return true;
  } else if (strpos($_SERVER['HTTP_REFERER'], 'weixin')) {
    $_SESSION['wechat_access'] = 1;
    setcookie('wechat_access', 1, (time() + (3600 * 24 * 3)), '/' .  get_sub_root());
    return true;
  } else {
    die('<meta charset="utf-8">请从微信中访问该页面');
    return false;
  }
}
