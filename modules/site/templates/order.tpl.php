<section class="tickets container">
  <div class="row">
<?php foreach ($settings['ticket_type'] as $idx => $ticket): ?>
    <div class="col-md-6 col-xs-12 ticket">
      <div class="image">
        <img class="img-thumbnail" src="<?php echo uri("modules/site/assets/images/ticket-$idx.jpg") ?>" title="<?php echo $ticket['name'] ?>" />
      </div>
      <h2><?php echo $ticket['name'] ?></h2>
      <div class="description">
        <?php echo $ticket['description'] ?>
      </div>
      <h3>折扣票价 <del>$<?php echo $ticket['original_cost'] ?></del> <span>$<?php echo $ticket['cost'] + $ticket['margin'] ?></span></h3>
        <form class="form-inline" method="GET" action="<?php echo uri('details') ?>">
          <input type="hidden" name="ticket_idx" value="<?php echo $idx ?>" />
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-addon">购买</div>
              <select class="form-control" name="ticket_num">
<?php for ($i = 1; $i < 11; $i++): ?>
                <option value="<?php echo $i ?>"><?php echo $i ?></option>
<?php endfor; ?>
              </select>
              <div class="input-group-addon">张</div>
            </div>
          </div>
          <input class="btn btn-danger" name="submit" type="submit" value="立即购买" />
          <p style="margin-top: 8px;"><small style="color: #777;">* 本票适用于观看标准场次电影，如需升级至3D或者Vmax，请在柜台办理手续，支付相应差价。请仔细阅读我们的<a href="#" data-toggle="modal" data-target="#terms">服务条款</a>。</small></p>
        </form>
    </div>
<?php endforeach; ?>
  </div>
</section>


<!-- Modal -->
<div class="modal fade" id="terms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">购票服务条款</h4>
      </div>
      <div class="modal-body">
        电子票会邮寄到您的邮箱，请确保您仔细检查邮箱垃圾桶，已避免邮件被误当成垃圾邮件。<?php echo $settings['ticket_type'][EtTicket::TYPE_ADULT_ESAVER]['name'] ?>不能在周六晚5点后使用。本票仅限于在以下影院使用：Event, Greater Union, or Birch Carroll & Coyle。本电子票不适用于Moonlight Cinema, Skyline Dive In 以及 Village Cinemas。本票适用于一名成人或学生的标准场次。请查看电子票上的有效日期，购买者需自行确保在有效日期前使用电子票。一旦超过有效日期，电子票上的条形码将失效。您可以使用本票在<a href="http://www.eventcinemas.com.au" target="_blank">www.eventcinemas.com.au</a>上预定座位，在线订座位会收取少量的费用。如您不需要提前预定座位，您也可以在入场前在售票处出示电子票，打印出来或者直接在手机上出示皆可。条形码一旦被扫码之后，电子票便失效了。条形码不可多次使用。请谨慎保管条形码和PIN码的信息。如您希望升级至Vmax或者3D，请在使用电子票兑换电影票时支付额外的费用。本票不适用于Gold Glass，团体票，电影马拉松或者其他高于标准电影票价的场次。本票不可以和其他促销活动同时使用，我们对您购票时输入的信息，诸如邮件地址等，不付任何责任，请在输入时确保您输入信息的准确性。本电子票不接受任何的退款，票子上的有效期不可以延后。本票仅限澳洲境内使用。
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">同意条款</button>
      </div>
    </div>
  </div>
</div>