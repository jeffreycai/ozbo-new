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
  _debug($_SERVER['HTTP_REFERER']);
}