<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

<?php echo YsUIPanel::initGrid('cellpadding="50px" cellspacing="50px"') ?>
  <?php echo YsUIPanel::initGridSection('width="50%"') ?>

    <?php echo YsUIPanel::initWidget('panelDraggabble', 'style="height:50px;width:50px;z-index:1"')?>
      Drag me to my target
    <?php echo YsUIPanel::endWidget()?>

  <?php echo YsUIPanel::endGridSection() ?>
  
  <?php echo YsUIPanel::initGridSection('width="50%"') ?>

    <?php echo YsUIPanel::initWidget('panelDraggabble2', 'style="height:50px;width:50px;z-index:1"')?>
      I can't be dropped
    <?php echo YsUIPanel::endWidget()?>

  <?php echo YsUIPanel::endGridSection() ?>


  <?php echo YsUIPanel::initGridSection('width="50%"') ?>

    <?php echo YsUIPanel::initWidget('panelDroppable', 'style="height:100px;width:100px"')?>
    Drop here
    <?php echo YsUIPanel::endWidget()?>

  <?php echo YsUIPanel::endGridSection() ?>
<?php echo YsUIPanel::endGrid() ?>
  
<?php echo YsUIDialog::endWidget() ?>



<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );
echo
YsJQuery::newInstance()
  ->execute(
    YsUIDraggable::build()->in('#panelDraggabble, #panelDraggabble2')
      ->_revert(true)
   ,YsUIDroppable::build()->in('#panelDroppable')
      ->_accept('#panelDraggabble')
      ->_drop(
        new YsJsFunction("
          $(this).addClass('ui-state-highlight').html('Dropped!');
        ")
      )
      ->_activeClass(YsUIConstant::HOVER_STATE)

  )
?>