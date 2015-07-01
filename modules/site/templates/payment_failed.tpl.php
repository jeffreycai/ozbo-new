<section>
  <div class="container">
    <h2><?php echo i18n(array(
        'en' => 'We are very sorry, but your payment is declined.',
        'zh' => '十分抱歉，您的支付请求被拒绝了'
    )) ?></h2>
    <p><?php echo i18n(array(
        'en' => 'No payment is taken from your credit card.',
        'zh' => '我们没有向您的信用卡收取任何费用。'
    )) ?></p>
    <h3><?php echo i18n(array(
        'en' => '"What? How??"',
        'zh' => '"什么？怎么可能？？"'
    )) ?></h3>
    <p><?php echo i18n(array(
        'en' => 'There are many reasons for a peyment to be declined. Some of them are:',
        'zh' => '支付请求被拒绝可能有许多的原因，以下列举了其中常见的情况'
    )) ?></p>
    <ul>
      <li><?php echo i18n(array(
          'en' => 'Your credit card information is not valid.',
          'zh' => '您的信用卡信息是无效的'
      )) ?></li>
      <li><?php echo i18n(array(
          'en' => 'There is not enough found in your account',
          'zh' => '您的帐户内没有足够的余额了'
      )) ?></li>
      <li><?php echo i18n(array(
          'en' => 'There is a temperary technical issue with the payment gateway',
          'zh' => '支付端遇到了暂时的技术性问题'
      )) ?></li>
    </ul>
    
    <p><?php echo i18n(array(
        'en' => 'Go back to <a href="' . uri('') .'">homepage</a> for another movie ticket booking.',
        'zh' => '<a href="' . uri('order') . '">返回</a>，试试再预订一次。'
    )) ?></p>
  </div>
</section>