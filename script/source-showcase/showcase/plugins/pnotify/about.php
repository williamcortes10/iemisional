<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_PNOTYFY); ?>
<?php $plugin = new YsPnotify() ?>
<?php $className = get_class($plugin) ?>
Version: <?php echo YsPnotify::VERSION ?>
<br/><br/>
License: <?php echo YsPnotify::LICENSE ?>
<br/><br/>
Home Page: <a href="http://pines.sourceforge.net/pnotify/">http://pines.sourceforge.net/pnotify/</a>
<br/><br/>
<h2>Introduction</h2>
<div style="text-align:justify">
<p>
  Pines Notify is a JavaScript notification plugin, developed
  by Hunter Perrin as part of
  <a href="http://sourceforge.net/projects/pines/">Pines</a>.
  It is designed to provide an unparalleled level of
  flexibility, while still being very easy to implement and
  use. It uses the jQuery UI CSS library for styling, which
  means it is fully and easily themeable. Try out some of the
  readymade themes using the selector in the top right corner
  of this page. It is licensed under the
  <a href="http://www.gnu.org/licenses/agpl-3.0.html">GNU Affero GPL</a>,
  which means you are free to use, study, modify, and
  freely redistribute it under the same license.
</p>
</div>
<br/><br/>
<h2>Plugin dependencies:</h2>
  <br/>
  <h6><a class="children">jquery.ui.css</a></h6>
<br/><br/>

<h2>Javascripts source:</h2>
<pre>
<?php echo htmlentities('<script type="text/javascript" src="jquery.pnotify.min.js"></script>'); ?>
</pre>
<br/><br/>

<h2>Style sheets:</h2>
<pre>
<?php echo htmlentities('
<link rel="stylesheet" type="text/css" href="jquery-ui-x.x.x.custom.css" />
<link rel="stylesheet" type="text/css" href="jquery.pnotify.default.css" />'); ?>
</pre>

<br/><br/>
<h2>Class name:</h2> <h2><u><?php echo $className ?></u></h2>
<br/><br/>
<h2>Parent class:</h2> <h2><u><?php echo get_parent_class($plugin) ?></u></h2>
<br/><br/>
<h2>Available Options / Events:</h2>
<br/>
<?php foreach ($plugin->registerOptions() as $option): ?>

  <h6><a class="children"><?php echo $option['key'] ?></a></h6>

<?php endforeach; ?>
<br/><br/>
<h2>Available Methods:</h2>
<br/>
<?php foreach (get_class_methods($plugin) as $method): ?>
  <?php if($method == '__call') break ?>
  <h6><a class="children"><?php echo sprintf("%s::%s()",$className,$method) ?></a></h6>
<?php endforeach; ?>
<br/><br/>
<h2>PHPDocs:</h2> Comming soon

