<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT); ?>

  <?php echo YsJLayout::initBorderlLayout(array(YsJLayout::HGAP => 3,
                                                YsJLayout::VGAP => 3)) ?>
    <?php echo YsJLayout::initCenter('centerPanel', 'style="width:320px; height:130px"') ?>

      <!--NESTED -->
      <?php echo YsJLayout::initBorderlLayout(array()) ?>
        <?php echo YsJLayout::initCenter('centerPanel', 'style="width:100px; height:50px"') ?>
        Nested Center
        <?php echo YsJLayout::endCenter() ?>
        <?php echo YsJLayout::initEast('eastPanel', 'style="width:100px; height:30px"') ?>
        Nested East
        <?php echo YsJLayout::endEast() ?>
        <?php echo YsJLayout::initWest('westPanel', 'style="width:100px; height:30px"') ?>
        Nested West
        <?php echo YsJLayout::endWest() ?>
        <?php echo YsJLayout::initNorth('northPanel', 'style="width:100px; height:30px"') ?>
        Nested North
        <?php echo YsJLayout::endNorth() ?>
        <?php echo YsJLayout::initSouth('southPanel', 'style="width:100px; height:30px"') ?>
        Nested South
        <?php echo YsJLayout::endSouth() ?>
      <?php echo YsJLayout::endBorderLayout()?>
      <!--NESTED -->
    <?php echo YsJLayout::endCenter() ?>
    <?php echo YsJLayout::initEast('eastPanel', 'style="width:100px; height:30px"') ?>
      East
    <?php echo YsJLayout::endEast() ?>
    <?php echo YsJLayout::initWest('westPanel', 'style="width:100px; height:30px"') ?>
      West
    <?php echo YsJLayout::endWest() ?>
    <?php echo YsJLayout::initNorth('northPanel', 'style="width:100px; height:30px"') ?>
      North
    <?php echo YsJLayout::endNorth() ?>
    <?php echo YsJLayout::initSouth('southPanel', 'style="width:100px; height:30px"') ?>
      South
    <?php echo YsJLayout::endSouth() ?>
  <?php echo YsJLayout::endBorderLayout()?>
<?php
echo
YsJQuery::newInstance()
  ->execute(
    YsJLayout::build('.border')
  )
?>