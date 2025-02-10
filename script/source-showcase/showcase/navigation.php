  <ul>
	<li class="jq-download jq-first"><a href="http://sourceforge.net/projects/jquery4php/files/"><span>Download</span></a></li>
  <li class="jq-documentation"><a href="http://jquery4php.sourceforge.net/documentation.php"><span>Documentation</span></a></li>
	<li class="jq-tutorials"><a href="http://jquery4php.sourceforge.net/tutorials.php"><span>Tutorials</span></a></li>
	<li class="jq-bugTracker"><a href="http://sourceforge.net/tracker/?group_id=308293"><span>Bug Tracker</span></a></li>
	<li class="jq-discussion jq-last"><a href="#" onclick="return false;"><span>Discussion</span></a></li>
  </ul>

<?php echo YsUIDialog::initWidget('dlgDiscussion','style="display:none"') ?>
  <br>
  Choose a discussion site
<?php echo YsUIDialog::endWidget()  ?>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('.jq-discussion')
  ->execute(
    YsUIDialog::build('#dlgDiscussion')
      ->_draggable(false)
      ->_resizable(false)
      ->_modal(true)
      ->_title('Discussion sites')
      ->_close(
        new YsJsFunction(YsUIDialog::destroyMethod('#dlgDiscussion'))
      )
      ->_buttons(array(
          'Google Group' => new YsJsFunction(YsJsFunction::redirect("http://groups.google.com/group/jquery4php")),
          'Sourceforge.net' =>  new YsJsFunction(YsJsFunction::redirect("http://sourceforge.net/projects/jquery4php/forums")))
       )
  )
?>