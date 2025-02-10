<?php YsJQuery::useComponent(YsJQueryConstant::PLUGIN_JQPLOT); ?>
<?php $plugin = new YsPlot("poltId") ?>
<?php $className = get_class($plugin) ?>
Version: <?php echo YsJQPlot::VERSION ?>
<br/><br/>
License: <?php echo YsJQPlot::LICENSE ?>
<br/><br/>
Home Page: <a href="http://www.jqplot.com/">http://www.jqplot.com/</a>
<br/><br/>
Author: <a href="http://www.jqplot.com/">Chris Leonello</a>
<br/><br/>
<h2>Introduction</h2>
<div style="text-align:justify">
<p>
Computation and drawing of lines, axes, shadows even the grid itself is handled
by pluggable "renderers". Not only are the plot elements customizable, plugins
can expand functionality of the plot too! There are plenty of hooks into the
core jqPlot code allowing for custom event handlers, creation of new plot types,
adding canvases to the plot, and more!
</p>
</div>
<br/><br/>
<h2>Plugin dependencies:</h2>
  <br/>
  <h6>
    <a class="children">excanvas.min.js (only for IE)</a><br/>
  </h6>
<br/><br/>

<h2>Javascripts source:</h2>

<pre>
<?php echo htmlentities('<script language="javascript" type="text/javascript" src="jquery.jqplot.min.js"></script>

<!-- JQPLOT PLUGINS ONLY INCLUDE IF NECESSARY -->

<script language="javascript" type="text/javascript" src="jqplot.categoryAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.dateAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.canvasTextRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.canvasAxisLabelRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.canvasAxisTickRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.barRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.dateAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.logAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.blockRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.enhancedLegendRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.bubbleRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.funnelRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.donutRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.mekkoRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.mekkoAxisRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.meterGaugeRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.ohlcRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.highlighter.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.BezierCurveRenderer.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.cursor.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.dragable.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript" src="jqplot.trendline.min.js"></script>'); ?>
</pre>

<br/><br/>

<h2>Style sheets:</h2>

<pre>
<?php echo htmlentities('<link rel="stylesheet" type="text/css" href="jquery.jqplot.min.css" />'); ?>
</pre>

<br/><br/>
<h2>Class name:</h2> <u><?php echo $className ?></u>
<br/><br/>
<h2>Parent class:</h2> <u><?php echo get_parent_class($plugin) ?></u>
<br/><br/>
<h2>Available Methods:</h2>
<br/>
<?php foreach (get_class_methods($plugin) as $method): ?>
  <?php if($method == '__call') break ?>
  <h6><a class="children"><?php echo sprintf("%s::%s()",$className,$method) ?></a></h6>
<?php endforeach; ?>
<br/><br/>
<h2>PHPDocs:</h2> Comming soon

