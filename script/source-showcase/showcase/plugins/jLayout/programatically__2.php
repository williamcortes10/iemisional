<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnBuildLayout">Layout</button>

<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT); ?>

  <div id="container">
    <?php echo YsJLayout::initCenter('centerPanel', 'style="width:33%; height:50px"') ?>
      Center
    <?php echo YsJLayout::endCenter() ?>
    <?php echo YsJLayout::initEast('eastPanel', 'style="width:33%; height:30px"') ?>
      East
    <?php echo YsJLayout::endEast() ?>
    <?php echo YsJLayout::initWest('westPanel', 'style="width:33%; height:30px"') ?>
      West
    <?php echo YsJLayout::endWest() ?>
    <?php echo YsJLayout::initNorth('northPanel', 'style="width:100%; height:30px"') ?>
      North
    <?php echo YsJLayout::endNorth() ?>
    <?php echo YsJLayout::initSouth('southPanel', 'style="width:100%; height:30px"') ?>
      South
    <?php echo YsJLayout::endSouth() ?>
  </div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in("#btnBuildLayout")
  ->execute(
    YsJLayout::build("#container")
      ->_type(YsJLayout::BORDER_TYPE)
      ->_west(YsJQuery::newInstance()->in("#westPanel"))
      ->_center(YsJQuery::newInstance()->in("#centerPanel"))
      ->_north(YsJQuery::newInstance()->in("#northPanel"))
      ->_east(YsJQuery::newInstance()->in("#eastPanel"))
      ->_south(YsJQuery::newInstance()->in("#southPanel"))
  )
?>