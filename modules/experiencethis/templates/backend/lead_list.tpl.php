

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"><?php i18n_echo(array('en' => 'Lead','zh' => '订单',)); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array('en' => 'List', 'zh' => '列表')) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<table class="table table-striped table-bordered table-hover dataTable no-footer">
  <thead>
      <tr role="row">
                <th>id</th>
                <th>email</th>
<!--                <th>wechat_id</th>-->
                <th>ticket_type</th>
                <th>ticket_num</th>
                <th>created_at</th>
                <th>processed</th>
                <th>processed_at</th>
                <th>Actions</th>
      </tr>
  </thead>
  <tbody>
    <?php foreach ($objects as $object): ?>
    <tr>
            <td><?php echo $object->getId() ?></td>
            <td><?php echo $object->getEmail() ?></td>
            <!--<td><?php echo $object->getWechatId() ?></td>-->
            <td><?php echo $settings['ticket_type'][$object->getTicketType()]['name'] ?></td>
            <td><?php echo $object->getTicketNum() ?></td>
            <td><?php echo date('Y-m-d', $object->getCreatedAt()) ?></td>
            <td><?php echo $object->getProcessed() ? '<span style="color: green" class="fa fa-check"></span>' : '<span style="color: red;" class="fa fa-times"></span>' ?></td>
            <td><?php echo $object->getProcessedAt() ? date('Y-m-d', $object->getProcessedAt()) : 'N/A' ?></td>
            <td>
        <div class="btn-group">
          <a class="btn btn-<?php echo $object->getProcessed() ? 'default' : 'success' ?> btn-sm" href="<?php echo uri('admin/lead/process/' . $object->getId()) ?>"><i class="fa fa-send">处理</i></a>
          <a class="btn btn-default btn-sm" href="<?php echo uri('admin/lead/edit/' . $object->getId()); ?>"><i class="fa fa-edit"></i></a>
          <a onclick="return confirm('<?php echo i18n(array('en' => 'Are you sure to delete this record ?', 'zh' => '你确定删除这条记录吗 ?')); ?>');" class="btn btn-default btn-sm" href="<?php echo uri('admin/lead/delete/' . $object->getId(), false); ?>"><i class="fa fa-remove"></i></a>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="row">
  <div class="col-sm-12" style="text-align: right;">
  <?php i18n_echo(array(
      'en' => 'Showing ' . $start_entry . ' to ' . $end_entry . ' of ' . $total . ' entries', 
      'zh' => '显示' . $start_entry . '到' . $end_entry . '条记录，共' . $total . '条记录',
  )); ?>
  </div>
  <div class="col-sm-12" style="text-align: right;">
  <?php echo $pager; ?>
  </div>
</div>
          
        </div>
      </div>
    </div>
  </div>
</div>