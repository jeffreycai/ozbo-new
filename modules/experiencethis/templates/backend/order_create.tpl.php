<div id="page-wrapper">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="page-header"><?php i18n_echo(array(
        'en' => 'Order',
        'zh' => '订单',
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
          
<form role="form" method="POST" action="<?php echo uri('admin/order/create') ?>">
  
<div class='form-group'>
  <label for='email'>email</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['email']) ? strip_tags($_POST['email']) : '') : $object->getEmail()))) ?>' type='email' class='form-control' id='email' name='email' required />
</div>
<div class='form-group'>
  <label for='retype_email'><?php echo i18n(array('en' => 'Retype', 'zh' => '再输一次')) ?> email</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', (isset($_POST['retype_email']) ? strip_tags($_POST['retype_email']) : ''))) ?>' type='email' class='form-control' id='retype_email' name='retype_email' required />
</div>
  
<div class='form-group'>
  <label for='wechat_id'>wechat_id</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['wechat_id']) ? strip_tags($_POST['wechat_id']) : '') : $object->getWechatId()))) ?>' type='text' class='form-control' id='wechat_id' name='wechat_id' />
</div>
  
<div class='form-group'>
  <label>ticket_type</label>
    <select class='form-control' id='ticket_type' name='ticket_type'>
      <option value='1' <?php echo ($object->isNew() ? (isset($_POST['ticket_type']) ? ($_POST['ticket_type'] == '1' ? 'selected="selected"' : '') : '') : ($object->getTicketType() == "1" ? "selected='selected'" : "")) ?>>Adult eSaver</option>
      <option value='2' <?php echo ($object->isNew() ? (isset($_POST['ticket_type']) ? ($_POST['ticket_type'] == '2' ? 'selected="selected"' : '') : '') : ($object->getTicketType() == "2" ? "selected='selected'" : "")) ?>>eMovie</option>
      <option value='3' <?php echo ($object->isNew() ? (isset($_POST['ticket_type']) ? ($_POST['ticket_type'] == '3' ? 'selected="selected"' : '') : '') : ($object->getTicketType() == "3" ? "selected='selected'" : "")) ?>>Child eSaver</option>
    </select>
</div>
  
<div class='form-group'>
  <label for='created_at'>created_at</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['created_at']) ? strip_tags($_POST['created_at']) : '') : $object->getCreatedAt()))) ?>' type='text' class='form-control' id='created_at' name='created_at' />
</div>
  
<div class='checkbox'>
  <label>
    <input type='checkbox' <?php echo ($object->isNew() ? (isset($_POST['processed']) ? ($_POST['processed'] ? 'checked="checked"' : '') : '') : ($object->getProcessed() ? "checked='checked'" : "")) ?> id='processed' name='processed' value='1' /> processed
  </label>
</div>
  
<div class='form-group'>
  <label for='processed_at'>processed_at</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['processed_at']) ? strip_tags($_POST['processed_at']) : '') : $object->getProcessedAt()))) ?>' type='text' class='form-control' id='processed_at' name='processed_at' />
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

