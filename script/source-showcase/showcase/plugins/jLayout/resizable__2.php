<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT); ?>

  <?php echo YsJLayout::initBorderlLayout(array(YsJLayout::HGAP => 3,
                                                YsJLayout::VGAP => 3,
                                                'resize' => true
                                                )
                                          ,'style="width:100%"') ?>
    <?php echo YsJLayout::initCenter('centerPanel', 'style="width:65%; height:50px"') ?>
      Center
    <?php echo YsJLayout::endCenter() ?>
    <?php echo YsJLayout::initWest('westPanel', 'style="width:35%; height:30px"') ?>
      West
    <?php echo YsJLayout::endWest() ?>
    <?php echo YsJLayout::initNorth('northPanel', 'style="width:100%; height:30px"') ?>
      North
    <?php echo YsJLayout::endNorth() ?>
    <?php echo YsJLayout::initSouth('southPanel', 'style="width:100%; height:30px"') ?>
      South
    <?php echo YsJLayout::endSouth() ?>
  <?php echo YsJLayout::endBorderLayout()?>
<?php
echo
YsJQuery::newInstance()
  ->execute(
      YsJLayout::build('.border'),
      YsUIResizable::build('#northPanel')->_handles('s'),
      YsUIResizable::build('#southPanel')->_handles('n'),
      YsUIResizable::build('#centerPanel')->_handles('w'),
      YsUIResizable::build('#westPanel')->_handles('e')
  )
?>