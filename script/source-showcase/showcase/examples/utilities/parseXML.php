<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<script language="javascript" type="text/javascript">
  function testXml(){
    xmlDoc = <?php echo YsJQuery::parseXML('<rss version="2.0"><channel><title>RSS Title</title></channel></rss>') ?>;
    $xml = $( xmlDoc ),
    $title = $xml.find( 'title' );
    alert($title.text());
  }
</script>

<div>
<input type="button" value="Get Data [GET]" id="ajaxGetType" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#ajaxGetType')
  ->execute('testXml()');
?>
</div>