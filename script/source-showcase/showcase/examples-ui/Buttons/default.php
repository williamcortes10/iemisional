<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

Checkbox: In this way, was builded when the buttonset is ready:
<br/><br/>

<?php echo YsUIButton::initButtonset('chkButtonsetId') ?>
  <?php echo YsUIButton::chekboxButton('chkButtonId1','B') ?>
  <?php echo YsUIButton::chekboxButton('chkButtonId2', 'I') ?>
  <?php echo YsUIButton::chekboxButton('chkButtonId3', 'U') ?>
<?php echo YsUIButton::endButtonset() ?>

<br/>
Radio: In this way, was builded when the buttonset is ready:
<br/><br/>

<?php echo YsUIButton::initButtonset('rdoButtonsetId') ?>
  <?php echo YsUIButton::radioButton('rdoButtonId1','B','name="radio"') ?>
  <?php echo YsUIButton::radioButton('rdoButtonId2','I','name="radio"') ?>
  <?php echo YsUIButton::radioButton('rdoButtonId3','U','name="radio"') ?>
<?php echo YsUIButton::endButtonset() ?>

<br/>
Radio: In this way is faster:
<br/><br/>
<div id="radio">
  <?php echo YsUIButton::radioButton('rdoButtonId11','B','name="radio1"') ?>
  <?php echo YsUIButton::radioButton('rdoButtonId12','I','name="radio1"') ?>
  <?php echo YsUIButton::radioButton('rdoButtonId13','I','name="radio1"') ?>
</div>
<?php echo YsUIButton::buildButtonset('#radio')->execute() ?>







