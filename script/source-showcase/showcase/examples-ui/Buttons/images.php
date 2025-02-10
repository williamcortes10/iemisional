<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<?php echo YsUIButton::buttonTag('btnButtonId1','Button with icon only') ?>
<?php echo YsUIButton::buttonTag('btnButtonId2','Button with icon on the left') ?>
<?php echo YsUIButton::buttonTag('btnButtonId3','Button with two icons') ?>
<?php echo YsUIButton::buttonTag('btnButtonId4','Button with two icons and no text') ?>

<?php
echo
YsJQuery::newInstance()
  ->execute(
    YsUIButton::build('#btnButtonId1')
      ->_text(false)
      ->_icons(array('primary' => 'ui-icon-locked')),
    YsUIButton::build('#btnButtonId2')
      ->_icons(array('primary' => 'ui-icon-locked')),
    YsUIButton::build('#btnButtonId3')
      ->_icons(array('primary' => 'ui-icon-gear',
                     'secondary' => 'ui-icon-triangle-1-s')),
    YsUIButton::build('#btnButtonId4')
      ->_icons(array('primary' => 'ui-icon-gear',
                     'secondary' => 'ui-icon-triangle-1-s'))
      ->_text(false)
  )
?>










