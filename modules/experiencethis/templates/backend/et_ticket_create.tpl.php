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
            'en' => 'Create', 
            'zh' => '创建'
        )) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<form role="form" method="POST" action="<?php echo uri('admin/et_ticket/create') ?>">
  
<div class='form-group'>
  <label for='url'>url</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['url']) ? strip_tags($_POST['url']) : '') : $object->getUrl()))) ?>' type='text' class='form-control' id='url' name='url' required size=256 />
</div>
  
<div class='form-group'>
  <label for='local_path'>local_path</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['local_path']) ? strip_tags($_POST['local_path']) : '') : $object->getLocalPath()))) ?>' type='text' class='form-control' id='local_path' name='local_path' />
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
  <label for='cost'>cost</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['cost']) ? strip_tags($_POST['cost']) : '') : $object->getCost()))) ?>' type='text' class='form-control' id='cost' name='cost' required />
</div>
  
<div class='form-group'>
  <label for='sent_at'>sent_at</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['sent_at']) ? strip_tags($_POST['sent_at']) : '') : $object->getSentAt()))) ?>' type='text' class='form-control' id='sent_at' name='sent_at' />
</div>
  
<div class='form-group'>
  <label for='created_at'>created_at</label>
  <input value='<?php echo htmlentities(str_replace('\'', '"', ($object->isNew() ? (isset($_POST['created_at']) ? strip_tags($_POST['created_at']) : '') : $object->getCreatedAt()))) ?>' type='text' class='form-control' id='created_at' name='created_at' />
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

