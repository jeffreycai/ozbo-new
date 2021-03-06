<div id="page-wrapper">
  <div class="row">
    <div class="col-xs-12">
      <h1 class="page-header"><?php i18n_echo(array(
        'en' => 'Lead',
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
          
<form role="form" method="POST" action="<?php echo uri('admin/lead/create') ?>">
  
<div class='form-group'>
  <label for='email'>email</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['email']) ? strip_tags($_POST['email']) : '') : $object->getEmail()))) ?>' type='text' class='form-control' id='email' name='email' required />
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
  <label>ticket_num</label>
    <select class='form-control' id='ticket_num' name='ticket_num'>
      <option value='1' <?php echo ($object->isNew() ? (isset($_POST['ticket_num']) ? ($_POST['ticket_num'] == '1' ? 'selected="selected"' : '') : '') : ($object->getTicketNum() == "1" ? "selected='selected'" : "")) ?>>1</option>
      <option value='2' <?php echo ($object->isNew() ? (isset($_POST['ticket_num']) ? ($_POST['ticket_num'] == '2' ? 'selected="selected"' : '') : '') : ($object->getTicketNum() == "2" ? "selected='selected'" : "")) ?>>2</option>
      <option value='3' <?php echo ($object->isNew() ? (isset($_POST['ticket_num']) ? ($_POST['ticket_num'] == '3' ? 'selected="selected"' : '') : '') : ($object->getTicketNum() == "3" ? "selected='selected'" : "")) ?>>3</option>
      <option value='4' <?php echo ($object->isNew() ? (isset($_POST['ticket_num']) ? ($_POST['ticket_num'] == '4' ? 'selected="selected"' : '') : '') : ($object->getTicketNum() == "4" ? "selected='selected'" : "")) ?>>4</option>
      <option value='5' <?php echo ($object->isNew() ? (isset($_POST['ticket_num']) ? ($_POST['ticket_num'] == '5' ? 'selected="selected"' : '') : '') : ($object->getTicketNum() == "5" ? "selected='selected'" : "")) ?>>5</option>
      <option value='6' <?php echo ($object->isNew() ? (isset($_POST['ticket_num']) ? ($_POST['ticket_num'] == '6' ? 'selected="selected"' : '') : '') : ($object->getTicketNum() == "6" ? "selected='selected'" : "")) ?>>6</option>
      <option value='7' <?php echo ($object->isNew() ? (isset($_POST['ticket_num']) ? ($_POST['ticket_num'] == '7' ? 'selected="selected"' : '') : '') : ($object->getTicketNum() == "7" ? "selected='selected'" : "")) ?>>7</option>
      <option value='8' <?php echo ($object->isNew() ? (isset($_POST['ticket_num']) ? ($_POST['ticket_num'] == '8' ? 'selected="selected"' : '') : '') : ($object->getTicketNum() == "8" ? "selected='selected'" : "")) ?>>8</option>
      <option value='9' <?php echo ($object->isNew() ? (isset($_POST['ticket_num']) ? ($_POST['ticket_num'] == '9' ? 'selected="selected"' : '') : '') : ($object->getTicketNum() == "9" ? "selected='selected'" : "")) ?>>9</option>
      <option value='10' <?php echo ($object->isNew() ? (isset($_POST['ticket_num']) ? ($_POST['ticket_num'] == '10' ? 'selected="selected"' : '') : '') : ($object->getTicketNum() == "10" ? "selected='selected'" : "")) ?>>10</option>
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

