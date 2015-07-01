<div id="page-wrapper">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="page-header"><?php i18n_echo(array(
        'en' => 'Transaction',
        'zh' => '交易',
      )); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array(
            'en' => 'Create', 
            'zh' => '创建'
        )) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<form role="form" method="POST" action="<?php echo uri('admin/transaction/create') ?>">
  
<div class='form-group'>
  <label for='ticket_id'>ticket_id</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['ticket_id']) ? strip_tags($_POST['ticket_id']) : '') : $object->getTicketId()))) ?>' type='text' class='form-control' id='ticket_id' name='ticket_id' />
</div>
  
<div class='form-group'>
  <label for='lead_id'>lead_id</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['lead_id']) ? strip_tags($_POST['lead_id']) : '') : $object->getLeadId()))) ?>' type='text' class='form-control' id='lead_id' name='lead_id' />
</div>
  
<div class='form-group'>
  <label for='timestamp'>timestamp</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['timestamp']) ? strip_tags($_POST['timestamp']) : '') : $object->getTimestamp()))) ?>' type='text' class='form-control' id='timestamp' name='timestamp' />
</div>
  
<div class='form-group'>
  <label for='payment'>payment</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['payment']) ? strip_tags($_POST['payment']) : '') : $object->getPayment()))) ?>' type='text' class='form-control' id='payment' name='payment' />
</div>
  
<div class='form-group'>
  <label for='gross_profit'>gross_profit</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['gross_profit']) ? strip_tags($_POST['gross_profit']) : '') : $object->getGrossProfit()))) ?>' type='text' class='form-control' id='gross_profit' name='gross_profit' />
</div>

  <input type="submit" name="submit" value="<?php i18n_echo(array(
      'en' => 'Create', 
      'zh' => '创建'
  )) ?>" class="btn btn-default">
</form>
          
        </div>
      </div>
    </div>
  </div>
</div>

