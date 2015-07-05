<section>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
    <h2>感谢您购买我们的电影票。<br />您的电子票会在5分钟内邮寄到您的电子邮箱</h2>
    <br />
    <p>如果您没有收到电子票，请查看是否被过滤进垃圾邮件。 <strong>所有的电子票恕不退款</strong>。
    </p>
    <p>如您有任何疑问，欢迎及时<a href="<?php echo uri('contact') ?>"><strong>联系我们</strong></a></p>
    <p>我们的微信客服号是： ozboxoffice</p>
    <br />
    <h3>您的订票详情</h3>

    <?php $html->renderOut('site/components/order_details', array(
        'ticket' => $settings['ticket_type'][$lead->getTicketType()],
        'ticket_num' => $lead->getTicketNum()
    )); ?>
      </div>
    </div>
    
    <div class="row">
      <div class="col-xs-12">
        <p><a href="<?php echo uri('order') ?>">&Lt; 返回订票页</a></p>
      </div>
    </div>
  </div>
</section>