<?php

// we clear session info for previous booking
unset($_SESSION['lead_id']);

// get params from POST
$token = isset($_POST['stripeToken']) ? $_POST['stripeToken'] : null;
$ticket_num = isset($_POST['ticket_num']) ? $_POST['ticket_num'] : null;
$ticket_idx = isset($_POST['ticket_idx']) ? $_POST['ticket_idx'] : null;
$total = isset($_POST['total']) ? $_POST['total'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;

$ticket = $settings['ticket_type'][$ticket_idx];

$response = 'failed';

// check if we have a stripe token
if (is_null($token)) {
  $response = "failed";

  $log = new Log('stripe', Log::ERROR, 'Stripe token missing');
  $log->save();
// if yes, call stripe API for peyment
} else {
  require_once MODULESROOT . DS . 'site' . DS . 'includes' . DS . 'libraries' . DS . 'stripe-php' . DS . 'lib' . DS . 'Stripe.php';
  
  // Set your secret key: remember to change this to your live secret key in production
  // See your keys here https://dashboard.stripe.com/account
  Stripe::setApiKey(ENV == 'prod' ? $settings['stripe']['live_secret_key'] : $settings['stripe']['test_secret_key']);

  // Get the credit card details submitted by the form
  // $token = $_POST['stripeToken'];

  // make description
  $fields = array(
      "email" => $email,
      "Ticket" => $ticket['name'], 
      "Cost" => $ticket['cost'], 
      "Margin" => $ticket['margin'],
      "Sale Price" => $ticket['cost'] + $ticket['margin'],
      "Num of Tickets" => $ticket_num,
      "Total" => $total);
  $description = "";
  foreach ($fields as $key => $val) {
    $description .= "[$key] => $val\n";
  }
  
  // Create the charge on Stripe's servers - this will charge the user's card
  try {
    $log = new Log('stripe', Log::NOTICE, 'Strip: 1. Calling Stripe API with fields - ' . serialize($description), $_SERVER['REMOTE_ADDR']);
    $log->save();

    // call Stripe API to charge
    $charge = Stripe_Charge::create(array(
      "amount" => round($total * 100), // amount in cents, again
      "currency" => "aud",
      "card" => $token,
      "description" => $description)
    );
    $log = new Log('stripe', Log::SUCCESS, 'Strip: 2. API call successful. Credit card charged.', $_SERVER['REMOTE_ADDR']);
    $log->save();
    $response = "success";
    
    
    
    // store the lead in db
    $lead = new Lead();
    $lead->setEmail($email);
    $lead->setTicketType($ticket_idx);
    $lead->setTicketNum($ticket_num);
    $lead->setCreatedAt(time());
    $lead->save();
    
    
    sendemailAdmin(
            ENV == 'prod' ? 'New lead created' : 'DEV: New lead created',
            str_replace("\n", '<br />', "<p>$description</p><p><strong>ID: </strong>" . $lead->getId() . "</p>")
    );
    
    if ($lead && $lead->getId()) {
      // store in session so that the payment_success page knows
      $_SESSION['lead_id'] = $lead->getId();
      
      
      $log = new Log('stripe', Log::SUCCESS, 'Strip: 3. Lead stored in local db.', $_SERVER['REMOTE_ADDR']);
      $log->save();
      
      
      //// send the client email with tickets
      $tickets = EtTicket::findAllUnsoldByType($ticket_idx);
      // when running out of stock, send alert
      if (sizeof($tickets) < $ticket_num) {
        $msg = 'Not enough stock for ticket type - ' . $ticket['name'] . '. <br />Asked for ' . $ticket_num . ', stock is ' . sizeof($tickets) . ' <br />LeadID: ' . $lead->getId() . '. <br />NOT PROCEEDED! Please mannually do it.';
        $log = new Log('ticket', Log::ERROR, $msg, $_SERVER['REMOTE_ADDR']);
        $log->save();
        
        sendemailAdmin('!! Not enough stock', $msg);
      // otherwise, send tickets to client
      } else {
        // send warning when stock is low
        if (sizeof($tickets) - $ticket_num  < $settings['stock_warning_threshold']) {
          $msg = 'Stock running low for ticket type - ' . $ticket['name'] . '. <br /><br />Remaining stock number is ' . (sizeof($tickets) - $ticket_num). '. <br /><br />Please purchase more.';
          $log = new Log('ticket', Log::WARNING, $msg, $_SERVER['REMOTE_ADDR']);
          $log->save();
          
          sendemailAdmin('!! Stock running short', $msg);
        }
        // prepare the tickets to send
        $tickets_to_send = array();
        for ($i = 0; $i < $ticket_num; $i++) {
          $t = $tickets[$i];
          $t->setSentAt(time());
          $t->save();
          $tickets_to_send[] = TICKET_DIR . DS . $t->getLocalPath();
        }
        // send tickets
        $email_template = load_fixture('site', 'email.yml');
        $html = new HTML();
        $details = $html->render('site/components/order_details', array(
            'ticket' => $ticket,
            'ticket_num' => $ticket_num
        ));
        sendTicketToClient($email_template['confirm']['subject'], $email_template['confirm']['content'].$details, $tickets_to_send, $email);
        // set transaction
        for ($i = 0; $i < $ticket_num; $i++) {
          $transaction = new Transaction();
          $transaction->setGrossProfit($ticket['margin']);
          $transaction->setLeadId($lead->getId());
          $transaction->setPayment($ticket['cost'] + $ticket['margin']);
          $transaction->setTicketId($tickets[$i]->getId());
          $transaction->setTimestamp(time());
          $transaction->save();
        }
        // update lead
        $lead = Lead::findById($lead->getId());
        $lead->setProcessed(1);
        $lead->setProcessedAt(time());
        $lead->save();
      }
      
      
    } else {
      $response = "failed";
      
      $log = new Log('stripe', Log::ERROR, 'Strip: 3. Lead failed to store in local db.', $_SERVER['REMOTE_ADDR']);
      $log->save();
    }
  } catch(Stripe_CardError $e) {
    // The card has been declined
    $response = "failed";
    
    // Since it's a decline, Stripe_CardError will be caught 
    $body = $e->getJsonBody();
    $err = $body['error'];
    $err_msg = "";
    foreach ($err as $key => $val) {
      $err_msg .= "[$key] => '$val'; ";
    }
    
    $log = new Log('stripe', Log::ERROR, 'Strip: 2. API call failed. Credit card not charged. Details: '.$err_msg, $_SERVER['REMOTE_ADDR']);
    $log->save();
  } catch (Stripe_InvalidRequestError $e) {
    // Invalid parameters were supplied to Stripe's API
    $response = "failed";
    $log = new Log('stripe', Log::ERROR, 'Stripe Invalid Request Error', $_SERVER['REMOTE_ADDR']);
    $log->save();
  } catch (Stripe_AuthenticationError $e) {
    // Authentication with Stripe's API failed 
    // (maybe you changed API keys recently)
    $response = "failed";
    $log = new Log('stripe', Log::ERROR, 'Stripe Authentication Error', $_SERVER['REMOTE_ADDR']);
    $log->save();
  } catch (Stripe_ApiConnectionError $e) {
    // Network communication with Stripe failed 
    $response = "failed";
    $log = new Log('stripe', Log::ERROR, 'Stripe API Connection Error', $_SERVER['REMOTE_ADDR']);
    $log->save();
  } catch (Stripe_Error $e) {
    // Display a very generic error to the user, and maybe send
    $response = "failed";
    $log = new Log('stripe', Log::ERROR, 'Stripe Error', $_SERVER['REMOTE_ADDR']);
    $log->save();
  } catch (Exception $e) {
    // Something else happened, completely unrelated to Stripe
    $response = "failed";
    $log = new Log('stripe', Log::ERROR, 'Unknown error', $_SERVER['REMOTE_ADDR']);
    $log->save();
  }
  
}

echo $response;