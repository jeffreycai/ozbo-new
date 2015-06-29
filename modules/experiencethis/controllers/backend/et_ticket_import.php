<?php

/*
https://www.experiencethis.com.au/evoucher/emJvb2Zm/NTY3MjUzNDExMTAw/RzFFNzQzNjczNzcy/OTNiYjBjZTMtZDJiYy00NGNlLWJhZTktYzdiYzk0MTM4Y2Uz

https://www.experiencethis.com.au/evoucher/emJvb2Zm/NTY3MjUzNDExMTAw/RzFFNzQzNjczNzg0/NTIzYzI0ZjQtMjU1OS00NmJiLTgxZWYtM2MxNGMzYjk0YjRi

https://www.experiencethis.com.au/evoucher/emJvb2Zm/NTY3MjUzNDExMTAw/RzFFNzQzNjczNzkz/NTY4ZWFhZTgtOGRhMi00ODg2LThlZDgtZWEzYTIyYzcxZWUz

https://www.experiencethis.com.au/evoucher/emJvb2Zm/NTY3MjUzNDExMTAw/RzFFNzQzNjczODA0/YWEwZDNhZGYtYzgwYy00YjUzLTkwYTAtZjI5Nzc5NDk4MDg4
 */

if (isset($_POST['submit'])) {
  $urls = $_POST['urls'];
  $matches = array();
  preg_match_all('/https:\/\/www\.experiencethis\.com\.au\/evoucher\/[^\s]+/', $urls, $matches);
  
  $error_flag = 0;
  $override_tickets = 0;
  if (isset($matches[0]) && sizeof($matches[0])) {
    foreach ($matches[0] as $url) {
      
      $ticket = EtTicket::findByUrl($url);
      $ticket = $ticket ? $ticket : new EtTicket();
      if ($ticket->isNew()) {
        $ticket->setUrl($url);
      }
      
      ///// load html to pdf
      $html = file_get_contents($url);
      if ($html == false) {
        Message::register(new Message(Message::DANGER, "Failed to get content for ticket: ".$url));
        $error_flag++;
      } else {
        // get ticket type
        $type;
        if (strpos($html, 'Adult eSaver')) {
            $type = EtTicket::TYPE_ADULT_ESAVER;
        } else if (strpos($html, 'eMovie')) {
            $type = EtTicket::TYPE_EMOVIE;
        } else {
            Message::register(new Message(Message::DANGER, 'Can not identify ticket type'));
            HTML::forwardBackToReferer();
        }

          $cost = $settings['ticket_type'][$type]['cost'];
          
          // replace img src with full path
          $html = preg_replace("/src=(['\"])\//", "src=$1https://www.experiencethis.com.au/", $html);
          // remove branding
          load_library_simple_html_dom();
          $dom = str_get_html($html);
          $dom->find('table',0)->outertext = '';
          $dom->find('table',1)->find('tr',1)->outertext = '';
          $html = $dom->save();
          // remove branding text
          $texts = array(
              'Valid for 6 months from purchase date. Minimum of 4 vouchers per transaction.',
              'Other terms and conditions apply;&nbsp;&nbsp;<a href="https://www.experiencethis.com.au/About-Experiencethis/eVoucher-Terms-and-Conditions">click&nbsp;here</a>&nbsp;.',
              'Each product transaction must be a minimum quantity of 4 &amp; maximum of 10 per item. Transaction quantity requirements cannot consist of multiple products. ',
              'experiencethis takes no responsibility',
              'eVouchers are valid for 6 months from date of purchase. ',
              'For NRMA Member general enquiries, please call 13 11 22. If you have any enquiries regarding your movie voucher transaction, please email nrma@experiencethis.com.au For Event Cinemas enquiries, visit www.eventcinemas.com.au/faq'
          );
          foreach ($texts as $text) {
            if (strpos($html, $text)) {
              $html = str_replace($text, '', $html);
            } else {
              Message::register(new Message(Message::WARNING, 'Failed to replace text: ' . $text));
            }
          }
          // write the html into a temp file
          $pdf = tempnam('/tmp', 'ozboxoffice');
          $pdf = $pdf . ".html";
          $file_name = get_random_string() . ".pdf";
          file_put_contents($pdf, $html);
          $result = shell_exec('/usr/local/bin/wkhtmltopdf.sh -s A5 ' . $pdf . ' ' . TICKET_DIR . DS . $file_name);
          unlink($pdf);
          if (strpos($result, 'Error')) {
            Message::register(new Message(Message::DANGER, 'wkhtmltopdf failed for url:<br />'.$url.'<br />'.$result));
            $error_flag++;
          } else {
            // delete old ticket first
            if (!$ticket->isNew()) {
              $ticket->deleteTicketFile();
            }
            $ticket->setLocalPath($file_name);
            $ticket->setTicketType($type);
            $ticket->setCost($cost);
            $ticket->setCreatedAt(time());
            if ($ticket->save()) {
              if (!$ticket->isNew()) {
                $override_tickets++;
              }
            } else {
              Message::register(new Message(Message::DANGER, 'Failed to save EtTicket for url: '.$url));
              $error_flag++;
            }
          }

      }
    }
  } else {
    Message::register(new Message(Message::DANGER, 'Does not find any matchable urls'));
  }
  
  if ($error_flag == 0) {
    Message::register(new Message(Message::SUCCESS, 'Successfully imported ' . sizeof($matches[0]) . ' tickets'));
    if ($override_tickets) {
      Message::register(new Message(Message::INFO, $override_tickets . ' tickets already exists. Override.'));
    }
  }
}

$html = new HTML();

$html->renderOut('core/backend/html_header', array(
  'title' => i18n(array(
  'en' => 'Import ExperienceThis Ticket',
  'zh' => '导入 ExperienceThis 电影票',
  )),
));
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');


$html->renderOut('experiencethis/backend/et_ticket_import');


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;