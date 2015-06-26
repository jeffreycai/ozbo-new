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
            'en' => 'Import', 
            'zh' => '导入'
        )) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<form role="form" method="POST" action="<?php echo uri('admin/et_ticket/import') ?>">
  <div class='form-group'>
    <label for='created_at'>URLs</label>
    <textarea name="urls" class="form-control" rows="15"></textarea>
  </div>

  <input type="submit" name="submit" value="<?php i18n_echo(array(
      'en' => 'Import', 
      'zh' => '导入'
  )) ?>" class="btn btn-default">
</form>
          
        </div>
      </div>
    </div>
  </div>
</div>

