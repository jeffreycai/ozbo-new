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
        </form>
    </div>
<?php endforeach; ?>
  </div>
</section>