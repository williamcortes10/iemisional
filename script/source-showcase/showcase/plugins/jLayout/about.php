<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT); ?>
<?php $plugin = new YsJLayout() ?>
<?php $className = get_class($plugin) ?>
Version: <?php echo YsJLayout::VERSION ?>
<br/><br/>
License: <?php echo YsJLayout::LICENSE ?>
<br/><br/>
Home Page: <a href="http://www.bramstein.com/projects/jlayout/">http://www.bramstein.com/projects/jlayout/</a>
<br/><br/>
<h2>Introduction</h2>
<div style="text-align:justify">
<p>The jLayout JavaScript library provides layout algorithms for laying
   out components. A component is an abstraction; it can be implemented in
   many ways, for example as items in a HTML5 Canvas drawing or as HTML
   elements. The jLayout library allows you to focus on drawing the
   individual components instead of on how to arrange them on your
   screen.
</p>
<p>The library currently provides four layout algorithms:
   <code class="methodname">border</code>, which lays out components in five
   different regions; <code class="methodname">grid</code>, which lays out
   components in a user defined grid, <code class="methodname">flex-grid</code>
   which offers a grid with flexible column and row sizes, and
   <code class="methodname">flow</code> which flows components in a user defined
   direction. Using the <code class="methodname">grid</code> and
   <code class="methodname">flex-grid</code> algorithms you can also create
   horizontal and vertical layouts. A <a href="jquery-plugin.html">jQuery plugin</a> to lay out (X)HTML elements is also
   available.
</p>
</div>
<br/><br/>
<h2>Plugin dependencies:</h2>
  <br/>
  <h6><a href="http://www.bramstein.com/projects/jsizes/" class="children">jquery.sizes.js</a></h6>
  <h6><a href="http://plugins.jquery.com/project/metadata" class="children">jquery.metadata.js</a> (optional)</h6>
<br/><br/>

<h2>Javascripts source:</h2>
<pre>
  <?php echo htmlentities('<script type="text/javascript" src="jlayout.border.js"></script>
  <script type="text/javascript" src="jlayout.flexgrid"></script>
  <script type="text/javascript" src="jlayout.flow.js"></script>
  <script type="text/javascript" src="jlayout.grid.js"></script>
  <script type="text/javascript" src="jquery.jlayout.js"></script>
  <script type="text/javascript" src="jquery.sizes.js"></script>
  <script type="text/javascript" src="jquery.metadata.js"></script>'); ?>
</pre>
<br/><br/>

<h2>Style sheets:</h2>
<pre></pre>

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

