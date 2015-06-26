<div id="page-wrapper">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="page-header"><?php i18n_echo(array(
        'en' => 'ExperienceThis Ticket',
        'zh' => 'ExperienceThis 电影票',
      )); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array(
            'en' => 'Order', 
            'zh' => 'Order'
        )) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<form role="form" method="POST" action="<?php echo uri('admin/et_ticket/order') ?>">
  
<div class='form-group'>
  <label>ticket_type</label>
    <select class='form-control' id='ticket_type' name='ticket_type'>
      <option value='1'>Adult eSaver</option>
      <option value='2'>eMovie</option>
      <option value='3'>Child eSaver</option>
    </select>
</div>
  
<div class='form-group'>
  <label for='number'>How many?</label>
  <select class='form-control' id='number' name='number'>
    <option value='4'>4</option>
    <option value='5'>5</option>
    <option value='6'>6</option>
    <option value='7'>7</option>
    <option value='8'>8</option>
    <option value='9'>9</option>
  </select>
</div>

  <input type="submit" name="submit" value="<?php i18n_echo(array(
      'en' => 'Order', 
      'zh' => 'Order'
  )) ?>" class="btn btn-default">
</form>
          
        </div>
      </div>
    </div>
  </div>
</div>

