<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT); ?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo YsJLayout::initBorderlLayout(array(YsJLayout::HGAP => 3,
                                                YsJLayout::VGAP => 3)
                                         ,'style="height:100%"'
                                          ) ?>
    <?php echo YsJLayout::initCenter('centerPanel', 'style="width:33%; height:50%"') ?>
      Center
    <?php echo YsJLayout::endCenter() ?>
    <?php echo YsJLayout::initEast('eastPanel', 'style="width:33%; height:50%"') ?>
      East
    <?php echo YsJLayout::endEast() ?>
    <?php echo YsJLayout::initWest('westPanel', 'style="width:33%; height:50%"') ?>
      West
    <?php echo YsJLayout::endWest() ?>
    <?php echo YsJLayout::initNorth('northPanel', 'style="width:100%; height:20%"') ?>
      North
    <?php echo YsJLayout::endNorth() ?>
    <?php echo YsJLayout::initSouth('southPanel', 'style="width:100%; height:10%"') ?>
      South
    <?php echo YsJLayout::endSouth() ?>
  <?php echo YsJLayout::endBorderLayout()?>
<?php echo YsUIDialog::endWidget() ?>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
      YsUIDialog::build('#dialogId')
        ->_modal(true)
        ->_resizable(true)
        ->_resizeStop(new YsJsFunction(YsJLayout::relayout('.border')))
        ->_open(new YsJsFunction(YsJLayout::relayout('.border')))
        ->_width(600)
        ->_height(500),
      YsUIResizable::build('#northPanel')->_handles('s')->_stop(new  YsJsFunction(YsJLayout::relayout('.border'))),
      YsUIResizable::build('#southPanel')->_handles('n')->_stop(new  YsJsFunction(YsJLayout::relayout('.border'))),
      YsUIResizable::build('#centerPanel')->_handles('ew')->_stop(new  YsJsFunction(YsJLayout::relayout('.border'))),
      YsUIResizable::build('#westPanel')->_handles('e')->_stop(new  YsJsFunction(YsJLayout::relayout('.border'))),
      YsUIResizable::build('#eastPanel')->_handles('w')->_stop(new  YsJsFunction(YsJLayout::relayout('.border')))
    )
?>