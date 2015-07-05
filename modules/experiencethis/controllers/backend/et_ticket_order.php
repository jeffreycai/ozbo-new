<?php
//die(encrypt('982'));
if (isset($_POST['submit'])) {
  $type = $_POST['ticket_type'];
  $number = $_POST['number'];
  
  // login to experiencethis first so that we have the cookie
/***
  $crawler = new Crawler();
  $crawler->setCookiePath(CACHE_DIR . DS . 'nrma_cookie.txt');
  $crawler->clearCookie();
  // get form token first
  $result = $crawler->read('https://www.experiencethis.com.au/Account/Login');
  $matches = array();
  $token;
  preg_match('/id="token"(.+)?value="(.+)?"/', $result, $matches);
  if (isset($matches[2])) {
    $token = $matches[2];
  } else {
    Message::register(new Message(Message::DANGER, "Error when geting Experiencethis login form token"));
    HTML::forwardBackToReferer();
  }
  
  $crawler->setReferer('https://www.experiencethis.com.au/Account/Login');
  $result = $crawler->post('https://www.experiencethis.com.au/Account/Login', array(
      "txtUserName" => decrypt($settings['experiencethis_account']['username']),
      "txtPassword" => decrypt($settings['experiencethis_account']['password']),
      "txtForm" => "",
      "token" => $token,
      "btnLogin.x" => rand(50, 60),
      "btnLogin.y" => rand(20, 29),
      "ReturnUrl" => ""
  ));
  if(strpos($result, 'Welcome back') == false) {
    Message::register(new Message(Message::DANGER, 'Error when logging into Experiencethis'));
    HTML::forwardBackToReferer();
  }
 * 
 */
  
  /** Start doing ticket purchase **/
  $crawler = new Crawler();
  $crawler->setCookiePath(CACHE_DIR . DS . 'nrma_cookie.txt');
  $crawler->clearCookie();
  $crawler->setReferer('https://www.experiencethis.com.au/mynrma/login');
  
  
  // get verification token
  $verification_token;
  $result = $crawler->read('https://www.experiencethis.com.au/mynrma/login');
  $matches = array();
  preg_match('/<[^<]+name="__RequestVerificationToken"[^<]+value="([^<]+)"/', $result, $matches);
  if (isset($matches[1])) {
    $verification_token = $matches[1];
  } else {
    Message::register(new Message(Message::DANGER, 'can not find verification token'));
    HTML::forwardBackToReferer();
  }
  
  // login first
//  $members = load_fixture('experiencethis', 'nrma_member.yml');
//  $member_idx = array_rand($members);
//  $member_id = $members[$member_idx];
  $member_id = $settings['nrma']['member_id'];
  
  $result = $crawler->post('https://www.experiencethis.com.au/mynrma/login', array(
      "tf_membernumber" => $member_id,
      "__RequestVerificationToken" => $verification_token,
  ));
  // check if we login successfully
  if (strpos($result, 'Adult eSaver') == false) {
    Message::register(new Message(Message::DANGER, 'Failed to login to NRMA for member #'));
    HTML::forwardBackToReferer();
  }
  // get sell items from the page
  load_library_simple_html_dom();
  $dom = str_get_html($result);
  $items = array();
  foreach ($dom->find('#content .item-product1') as $box) {
    $name = $box->find('h2') ? $box->find('h2',0)->innertext : null;
    $price = $box->find('.addtocart', 0) ? $box->find('.addtocart', 0)->{"data-price"} : null;
    $productid = $box->find('.addtocart', 0) ? $box->find('.addtocart', 0)->{"data-id"} : null;
    $quantity = $number;
    
    if (!$name || !$price || !$productid || !$quantity) {
      Message::register(new Message(Message::DANGER, 'Failed to find ticket details'));
      HTML::forwardBackToReferer();
    }
    
    $items[$name] = array(
        'price' => $price,
        'productid' => $productid,
        'quantity' => $quantity
    );
  }
  $ticket = $settings['ticket_type'][$type];
  if (isset($items[$ticket['original_name']])) {
    $ticket = $items[$ticket['original_name']];
  } else {
    Message::register(new Message(Message::DANGER, 'Can not find a matching ticket type'));
    HTML::forwardBackToReferer();
  }
  // add item to cart
  $crawler->setReferer('https://www.experiencethis.com.au/mynrma');
  $result = $crawler->post('https://www.experiencethis.com.au/Cart/AddToCart', array(
      "productid" => $ticket['productid'],
      "unitprice" => $ticket['price'],
      "quantity" => $ticket['quantity'],
      "evoucherid" => 0
  ));
  $cart = json_decode($result);
  if (!is_object($cart) || !isset($cart->CartItems) || !isset($cart->CartTotal)) {
    Message::register(new Message(Message::DANGER, 'Failed to add to cart'));
    HTML::forwardBackToReferer();
  }
  // "cart summary" page - step 1
  $crawler->setReferer('https://www.experiencethis.com.au/mynrma');
  $crawler->read('https://www.experiencethis.com.au/mynrma/cart');
  // "you details" page - step 2
//  $buyers = load_fixture('experiencethis', 'fake_buyers.yml');
//  $buyer_index = array_rand($buyers);
//  $buyer = $buyers[$buyer_index];
  
  $buyer = $settings['buyer'];
  
  $crawler->setReferer('https://www.experiencethis.com.au/mynrma/cart');
  $crawler->read('https://www.experiencethis.com.au/mynrma/details');
  $crawler->setReferer('https://www.experiencethis.com.au/mynrma/details');
  $crawler->post('https://www.experiencethis.com.au/mynrma/details', array(
      "detailEmail" => $buyer["email"],
      "detailTitle" => $buyer["title"],
      "detailFirstName" => $buyer["firstname"],
      "detailLastName" => $buyer["lastname"],
      "detailAddress1" => $buyer["address1"],
      "detailSuburb" => $buyer["suburb"],
      "detailAddress2" => "",
      "detailState" => $buyer["state"],
      "detailPostcode" => $buyer["postcode"],
      "detailAgree" => "on"
  ));
  // "shipping details" - step 3
  $crawler->setReferer('https://www.experiencethis.com.au/mynrma/Shipping');
  $result = $crawler->post('https://www.experiencethis.com.au/mynrma/Shipping', array(
      "same" => "on",
      "tf_title" => "Mr",
      "tf_firstname" => "",
      "tf_lastname" => "",
      "tf_address" => "",
      "tf_suburb" => "",
      "tf_address2" => "",
      "tf_state" => "NSW",
      "tf_post" => ""
  ));
  // "online payment" - step 4
  $crawler->setReferer('https://www.experiencethis.com.au/mynrma/Payment');
  $result = $crawler->post('https://www.experiencethis.com.au/mynrma/Payment', array(
      "tf_card_name" => decrypt($settings['cc']['name']),
      "tf_card_number" => decrypt($settings['cc']['number']),
      "tf_month" => decrypt($settings['cc']['month']), // e.g. "02"
      "tf_year" => decrypt($settings['cc']['year']), // e.g. "14"
      "tf_cvv" => decrypt($settings['cc']['cvv'])
  ));
  // "confirm order" - step 5
  if (strpos($result, 'Confirm and Buy') == false) {
    Message::register(new Message(Message::DANGER, 'Payment confirm page is not correct'));
    HTML::forwardBackToReferer();
  }
  $crawler->setReferer('https://www.experiencethis.com.au/mynrma/Confirm');
  $result = $crawler->post('https://www.experiencethis.com.au/mynrma/Confirm', array(
      "CardName" => decrypt($settings['cc']['name']),
      "CardNumber" => decrypt($settings['cc']['number']),
      "CVV" => decrypt($settings['cc']['cvv']),
      "ExipryMonth" => decrypt($settings['cc']['month']),
      "ExipryYear" => decrypt($settings['cc']['year'])
  ));
  // final, see if the transaction is good or not
  if (strpos($result, 'Congratulations!')) {
    Message::register(new Message(Message::SUCCESS, 'Ticket successfully purchased!!'));
  } else {
    Message::register(new Message(Message::DANGER, 'Error with credit card payment: <br /><br />' . $result));
  }
  HTML::forwardBackToReferer();
}

$html = new HTML();

$html->renderOut('core/backend/html_header', array(
  'title' => i18n(array(
  'en' => 'Order ExperienceThis Ticket',
  'zh' => 'Order ExperienceThis 电影票',
  )),
));
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('experiencethis/backend/et_ticket_order');


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;

