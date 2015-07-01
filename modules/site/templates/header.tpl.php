<nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
        <span class="sr-only"><?php echo i18n(array(
                'en' => 'Toggle navbar',
                'zh' => '折叠导航栏'
        )); ?></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="/" class="navbar-brand blue"><span class=" glyphicon glyphicon-film"></span> <?php echo $settings['sitename'] ?></a>
    </div>
    <nav id="navbar" class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
      <ul class="nav navbar-nav">
        <li <?php if (isset($active_url) && in_array('/', $active_url)): ?>class="active"<?php endif; ?>><a href="/"><?php echo i18n(array(
            'en' => 'Home',
            'zh' => '首页'
        )) ?></a></li>
        <li <?php if (isset($active_url) && in_array('/booking', $active_url)): ?>class="active"<?php endif; ?>><a href="/booking"><?php echo i18n(array(
            'en' => 'Booking',
            'zh' => '订票'
        )) ?></a></li>
        <li <?php if (isset($active_url) && in_array('/contact', $active_url)): ?>class="active"<?php endif; ?>><a href="/contact"><?php echo i18n(array(
            'en' => 'Contact',
            'zh' => '联系'
        )) ?></a></li>
      </ul>
    </nav>
  </div>
</nav>