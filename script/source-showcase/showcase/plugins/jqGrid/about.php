<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JQGRID); ?>
<?php $plugin = new YsJQGrid() ?>
<?php $className = get_class($plugin) ?>
Version: <?php echo YsJQGrid::VERSION ?>
<br/><br/>
License: <?php echo YsJQGrid::LICENSE ?>
<br/><br/>
Home Page: <a href="http://www.trirand.com/blog/">http://www.trirand.com/blog/</a>
<br/><br/>
<h2>Introduction</h2>
<div style="text-align:justify">
<p>
 jqGrid is an Ajax-enabled JavaScript control that provides solutions for 
 representing and manipulating tabular data on the web. Since the grid is a
 client-side solution loading data dynamically through Ajax callbacks, it can
 be integrated with any server-side technology, including PHP, ASP,
 Java Servlets, JSP, ColdFusion, and Perl.
 jqGrid uses a jQuery Java Script Library and is written as plugin for that
 package
</p>
</div>
<br/><br/>
<h2>Plugin dependencies:</h2>
  <br/>
  <h6>
    <a class="children">jQuery UI</a><br/>
    <a class="children">jquery.tablednd.js</a>
  </h6>
<br/><br/>

<h2>Javascripts source:</h2>
<pre>
<?php echo htmlentities('<link rel="stylesheet" type="text/css" href="ui.jqgrid.css" />'); ?>
</pre>
<br/><br/>

<h2>Style sheets:</h2>
<pre>
<?php echo htmlentities('
<script type="text/javascript" src="grid.locale-en.js"></script>
<script type="text/javascript" src="jquery.jqGrid.min.js"></script>'); ?>
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

