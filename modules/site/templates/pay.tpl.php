<div class="container">
  
  <div class="row">
    <div class="col-xs-12">
      <div role="alert" class="alert alert-warning"><span class="glyphicon glyphicon-info-sign"></span> 请再次确认您的订票信息，并使用信用卡支付</div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12">
    <?php echo $html->renderOut('site/components/order_details', array(
        'ticket' => $ticket,
        'ticket_num' => $ticket_num
    )); ?>
    </div>
  </div>
  
  
  <div class="row">
    <div class="col-xs-12" style="text-align: right; font-size: 0.9em;">
      <span class="glyphicon glyphicon-remove" style="color: #ba2025;"></span> <a href="<?php echo uri('order') ?>"> 订票信息不正确，我要修改</a>
    </div>
  </div>
  
  
<div class="row">
  <div class="col-xs-12">
    <div style="display: block; margin-top: 15px;">
      <div class="panel panel-default">
        <div style="position: relative;" class="panel-heading">
          <h3 class="panel-title">付款</h3>
          <img alt="" src="/modules/site/assets/images/stripe-logo.png" style="position: absolute; top: 6px; right: 6px;">
        </div>
        <div id="options" class="panel-body">
          <div id="powered-by" class="row">
            <div class="col-xs-12">
              <img width="113" height="23" border="0" src="/modules/site/assets/images/cards.gif" alt="Accepted cards" id="cards">
            </div>
          </div>
            
          <form id="creditcard" method="POST" autocomplete="off" action="<?php echo uri('pay') ?>">
            <div class="row">
              <div class="col-xs-12">
                <div class="alert alert-danger payment-errors" role="alert" style="display: none;"></div>
                <div class="form-group">
                  <label><?php echo i18n(array(
                      'en' => 'Card Number',
                      'zh' => '卡号'
                  )) ?></label>
                  <input id="card-number" class="form-control" type="text" size="20" maxlength="20" data-stripe="number" placeholder="<?php echo i18n(array(
                      'en' => 'Your credit card number',
                      'zh' => '您的信用卡卡号'
                  )) ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label>CVC</label>
                  <input id="card-cvd" class="form-control" type="text" size="4" maxlength="4" data-stripe="cvc" placeholder="<?php echo i18n(array(
                      'en' => 'CVC number',
                      'zh' => 'CVC码'
                  )) ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label><?php echo i18n(array(
                      'en' => 'Expiration (MM/YYYY)',
                      'zh' => '信用卡有效日期'
                  )) ?></label>
                  <div class="form-control dummy">
                  <input id="exp-month" type="text" size="2" maxlength="2" data-stripe="exp-month" placeholder="MM" autocomplete="off" /> /
                  <input id="exp-year" type="text" size="4" maxlength="4" data-stripe="exp-year" placeholder="YYYY" autocomplete="off" />
                  </div>
                </div>
                <div class="row" id="pay">
                  <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary"><?php echo i18n(array(
                        'en' => 'Pay now',
                        'zh' => '现在支付'
                    )) ?></button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          
          
<!--          <div id="paypal">
            This is paypal
          </div>-->
        </div>
      </div>
    </div>
  </div>
    </div>
</div>






<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
// This identifies your website in the createToken call below
Stripe.setPublishableKey('<?php echo ENV == 'prod' ? $settings['stripe']['live_publishable_key'] : $settings['stripe']['test_publishable_key'] ?>');
var payment_btn_text;
jQuery(function($){
  $('#creditcard').submit(function(event) {
    event.preventDefault();
    
    var $form = $(this);
    payment_btn_text = $form.find('button').html();

    // Disable the submit button to prevent repeated clicks
    $form.find('button').prop('disabled', true).html("<?php echo i18n(array(
        'en' => 'Processing ...',
        'zh' => '处理中 ...'
    )) ?>  <img src='<?php echo get_sub_root(); ?>/modules/site/assets/images/ajax-loader.gif' alt='<?php echo i18n(array(
              'en' => 'loading',
              'zh' => '加载中'
            )); ?>' />");

    Stripe.card.createToken($form, stripeResponseHandler);

    // Prevent the form from submitting with the default action
    return false;
  });
});

function stripeResponseHandler(status, response) {
  var $form = $('#creditcard');

  if (response.error) {
    // Show the errors on the form
    var message = '';
    switch (response.error.code) {
      case 'incorrect_number':
        message = '<?php echo i18n(array(
            'en' => 'Your card number is incorrect.',
            'zh' => '您的卡号不正确'
        )) ?>'; break;
      case 'invalid_number':
        message = '<?php echo i18n(array(
            'en' => 'The card number is not a valid credit card number.',
            'zh' => '您填写的卡号不是一张有效的信用卡卡号'
        )) ?>'; break;
      case 'invalid_expiry_month':
        message = '<?php echo i18n(array(
            'en' => "The card\'s expiration month is invalid.",
            'zh' => '您填写的有效期月份不合法'
        )) ?>'; break;
      case 'invalid_expiry_year':
        message = '<?php echo i18n(array(
            'en' => "The card\'s expiration year is invalid.",
            'zh' => '您填写的有效期年份不合法'
        )) ?>'; break;
      case 'invalid_cvc':
        message = '<?php echo i18n(array(
            'en' => "Your card\'s security code (cvc) is invalid",
            'zh' => '您的CVC安全码无效'
        )) ?>'; break;
      case 'expired_card':
        message = '<?php echo i18n(array(
            'en' => 'The card has expired.',
            'zh' => '您的信用卡已过期'
        )) ?>'; break;
      case 'incorrect_cvc':
        message = '<?php echo i18n(array(
            'en' => "The card\'s security code (cvc) is incorrect.",
            'zh' => '您的CVC安全码不正确'
        )) ?>'; break;
      case 'incorrect_zip':
        message = '<?php echo i18n(array(
            'en' => "The card\'s zip code failed validation.",
            'zh' => '信用卡的zip码验证失败'
        )) ?>'; break;
      case 'card_declined':
        message = '<?php echo i18n(array(
            'en' => 'The card was declined.',
            'zh' => '信用卡支付请求被拒绝了'
        )) ?>'; break;
      case 'missing':
        message = '<?php echo i18n(array(
            'en' => 'There is no card on a customer that is being charged.',
            'zh' => '支付客户无信用卡'
        )) ?>'; break;
      case 'processing_error':
        message = '<?php echo i18n(array(
            'en' => 'An error occurred while processing the card.',
            'zh' => '信用卡支付处理出错'
        )) ?>'; break;
      case 'rate_limit':
        message = '<?php echo i18n(array(
            'en' => 'An error occurred due to requests too frequent.',
            'zh' => '支付请求过频'
        )) ?>'; break;
      default:
        message = '<?php echo i18n(array(
            'en' => 'An error has occured when processing your request',
            'zh' => '处理支付请求时出现错误'
        )) ?>';
    }
    
    $form.find('.payment-errors').show().html('<span class="glyphicon glyphicon-warning-sign"></span> ' + message);
    $form.find('button').prop('disabled', false).html(payment_btn_text);
  } else {
    // response contains id and card, which contains additional card details
    var stripeToken = response.id;
    // ajax call to server end for payment
    $.ajax({
      url: '<?php echo uri("payment"); ?>',
      type: "POST",
      data: 'stripeToken=' + encodeURIComponent(stripeToken) + "&ticket_num=<?php echo $ticket_num ?>" + "&ticket_idx=<?php echo $ticket_idx ?>" + "&total=<?php echo urlencode($ticket_num * ($ticket['cost']+$ticket['margin'])) ?>" + "&email=<?php echo urlencode($email) ?>",
      success: function(data){
        if (data == 'success') {
          window.location = '<?php echo uri('payment/success') ?>';
        } else {
//          window.location = '<?php echo uri('payment/failed') ?>';
        }
      },
      error: function(){
        window.location = '<?php echo uri('payment/failed') ?>';
      }
    });
  }
};
</script>