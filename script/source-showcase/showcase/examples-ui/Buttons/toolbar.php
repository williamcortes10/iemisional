<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none;padding:0" title="Basic dialog"') ?>

  <?php echo YsUIButton::initToolbar('toolbarId') ?>
    <?php echo YsUIButton::buttonTag('beginning', 'go to beginning') ?>
    <?php echo YsUIButton::buttonTag('rewind','rewind') ?>
    <?php echo YsUIButton::buttonTag('play','play') ?>
    <?php echo YsUIButton::buttonTag('stop','stop') ?>
    <?php echo YsUIButton::buttonTag('forward','fast forward') ?>
    <?php echo YsUIButton::buttonTag('end','go to end') ?>
    <?php echo YsUIButton::chekboxButton('shuffle','Shuffle') ?>

    <?php echo YsUIButton::initButtonset('rdoButtonsetId') ?>
      <?php echo YsUIButton::radioButton('repeat0','No Repeat','name="repeat"') ?>
      <?php echo YsUIButton::radioButton('repeat1','Once','name="repeat"') ?>
      <?php echo YsUIButton::radioButton('repeatall','All','name="repeat"') ?>
    <?php echo YsUIButton::endButtonset() ?>
    &nbsp;&nbsp;
    <input type="text" value="Text" />
   <?php echo YsUIButton::buttonTag('search','Search') ?>
  <?php echo YsUIButton::endToolbar() ?>
<?php echo YsUIDialog::endWidget() ?>
<?php
echo
YsJQuery::newInstance()
  ->execute(
    YsUIButton::build('#beginning')
      ->_text(false)
      ->_icons(array('primary' => YsUIConstant::ICON_SEEK_START)),
    YsUIButton::build('#rewind')
      ->_text(false)
      ->_icons(array('primary' => YsUIConstant::ICON_SEEK_PREV)),
    YsUIButton::build('#play')
      ->_text(false)
      ->_icons(array('primary' => YsUIConstant::ICON_PLAY)),
    YsUIButton::build('#stop')
      ->_text(false)
      ->_icons(array('primary' => YsUIConstant::ICON_STOP)),
    YsUIButton::build('#forward')
      ->_text(false)
      ->_icons(array('primary' => YsUIConstant::ICON_SEEK_NEXT)),
    YsUIButton::build('#end')
      ->_text(false)
      ->_icons(array('primary' => YsUIConstant::ICON_SEEK_END)),
    YsUIButton::build('#shuffle'),
    YsUIButton::build('#search')
      ->_icons(array('primary' => YsUIConstant::ICON_SEARCH))
  )
?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_width(700)
      ->_modal(true)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  )
?>

<?php
//actions:
echo
YsJQuery::toggle()
  ->in('#play')
  ->handler(
      YsUIButton::build('this')
        ->_label('pause')
        ->_icons(array('primary' => YsUIConstant::ICON_PAUSE)))
  ->handler(
      YsUIButton::build('this')
        ->_label('play')
        ->_icons(array('primary' => YsUIConstant::ICON_PLAY)))
  ->execute();
  
echo
YsJQuery::click()
  ->in('#stop')
  ->handler(
      YsUIButton::build('#play')
        ->_label('play')
        ->_icons(array('primary' => YsUIConstant::ICON_PLAY)))
  ->execute();
?>