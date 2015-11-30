<?php
// create ticket dir
define('TICKET_DIR', WEBROOT . "/files/tickets");
if (!is_dir(TICKET_DIR)) {
  mkdir(TICKET_DIR);
} else if (!is_writable(TICKET_DIR)) {
  die('Ticket dir needs to be writable.');
}



// register admin
$user = User::getInstance();
if (is_backend() && $user->isLogin()) {
  Backend::registerSideNav(
  '
  <li>
    <a href="#"><i class="fa fa-folder-open"></i> '.i18n(array('en' => 'ExperienceThis Ticket','zh' => 'ExperienceThis 电影票',)).'<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
      <li><a href="'.uri('admin/et_ticket/list').'">'.i18n(array(
          'en' => 'List',
          'zh' => '列表'
      )).'</a></li>
      <li><a href="'.uri('admin/et_ticket/create').'">'.i18n(array(
          'en' => 'Create',
          'zh' => '创建'
      )).'</a></li>
      <li><a href="'.uri('admin/et_ticket/import').'">'.i18n(array(
          'en' => 'Import',
          'zh' => '导入'
      )).'</a></li>
<!--      <li><a href="'.uri('admin/et_ticket/order').'">'.i18n(array(
          'en' => 'Order',
          'zh' => 'Order'
      )).'</a></li> -->
    </ul>
  </li>
  '        
  );
}


// register admin
$user = User::getInstance();
if (is_backend() && $user->isLogin()) {
  Backend::registerSideNav(
  '
  <li>
    <a href="#"><i class="fa fa-folder-open"></i> '.i18n(array('en' => 'Lead','zh' => '订单',)).'<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
      <li><a href="'.uri('admin/lead/list').'">'.i18n(array(
          'en' => 'List',
          'zh' => '列表'
      )).'</a></li>
      <li><a href="'.uri('admin/lead/create').'">'.i18n(array(
          'en' => 'Create',
          'zh' => '创建'
      )).'</a></li>
    </ul>
  </li>
  '        
  );
}


// register admin
$user = User::getInstance();
if (is_backend() && $user->isLogin()) {
  Backend::registerSideNav(
  '
  <li>
    <a href="#"><i class="fa fa-folder-open"></i> '.i18n(array('en' => 'Transaction','zh' => '交易',)).'<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
      <li><a href="'.uri('admin/transaction/list').'">'.i18n(array(
          'en' => 'List',
          'zh' => '列表'
      )).'</a></li>
      <li><a href="'.uri('admin/transaction/create').'">'.i18n(array(
          'en' => 'Create',
          'zh' => '创建'
      )).'</a></li>
    </ul>
  </li>
  '        
  );
}
