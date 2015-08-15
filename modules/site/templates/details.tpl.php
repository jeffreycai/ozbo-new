<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <h3>您的订单详情</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div role="alert" class="alert alert-info"><span class="glyphicon glyphicon-info-sign"></span> 本次购票我们帮您节省了 <span style="font-weight:bold; color: #d43d5c;">$<?php echo round($ticket_num * ($ticket['original_cost'] - $ticket['cost'] - $ticket['margin']), 2) ?></span> !</div>
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
      <form action="<?php echo uri('pay') ?>" method="GET">
        <input type="hidden" name="ticket_idx" value="<?php echo $ticket_idx ?>" />
        <input type="hidden" name="ticket_num" value="<?php echo $ticket_num ?>" />
      <div style="display: block; margin-top: 15px;">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">请填写您的邮箱地址接收电子票（十分重要）</h3>
          </div>
          <div class="panel-body">
            
            <?php echo Message::renderMessages() ?>
            
            <div class="row">
              <div class="col-xs-12">
                <p><small>电影票会以email的形式发送到您的电子邮箱。 请在观影时将电影票打印出来，或者直接出示手机上的电子票扫码即可。</small>
                  <br />
                  <small style="color: red;">由于QQ邮箱受大量垃圾邮件影响，已开始屏蔽任何自动邮件系统，请选用其他非QQ邮箱接收我们的电子票，谢谢</small>
                </p>
                <div class="form-group">
                  <label>请填写接收电子票的邮箱</label>
                  <input type="email" placeholder="Your email" required="required" class="form-control" id="email" name="email">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label>请再次确认您的邮箱地址</label>
                  <input type="email" placeholder="Confirm email" class="form-control" required="required" id="email_confirm" name="email_confirm">
                </div>
              </div>
            </div>
            <div id="confirm" class="row">
              <div class="col-xs-12" style="text-align: right;">
                <input class="btn btn-success" name="submit" type="submit" value="前往支付页" >
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>


