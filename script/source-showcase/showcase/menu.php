<?php
$noList = array('response');
$path = "about";
$dir_handle = @opendir($path) or die("Unable to open '$path' source dir.");

//menu display
YsJQuery::newInstance()
  ->execute(
    YsJQuery::toggle()
      ->in('.super')
      ->handler(
       new YsJQueryDynamic(
          YsJQuery::nextAll('ul')->in(YsJQueryConstant::THIS),
          YsJQuery::show()
        )
      )
      ->handler(
       new YsJQueryDynamic(
          YsJQuery::nextAll('ul')->in(YsJQueryConstant::THIS),
          YsJQuery::hide()
        )
      )
  )->write()
?>

<div style="min-height: 210em;" id="jq-interiorNavigation">
  <h2 class="jq-clearfix roundTop section-title">About</h2>
	<div class="roundBottom jq-box">
		<ul class="xoxo">
		  <li>
        <ul>
        <?php while ($file = readdir($dir_handle)): ?>
        <?php if(!is_dir($file) && !in_array($file, $noList)): ?>
          <li><a href="#" class="super" ><span>-</span> <?php echo ucfirst($file) ?></a>
            <?php $child_dir_handle = @opendir($path . DIRECTORY_SEPARATOR . $file) or die("Unable to open '".$path . DIRECTORY_SEPARATOR . $file ."' source dir."); ?>
              <?php while ($childrenFile = readdir($child_dir_handle)): ?>
                <?php if(!is_dir($childrenFile) && !in_array($childrenFile, $noList)): ?>
                <?php $method = str_replace('.php', null, $childrenFile) ?>
                <?php if(isset($_GET['module']) && $file == $_GET['module']):?>
                  <ul class="children">
                <?php else:?>
                  <ul class="children" style="display:none">
                <?php endif;?>
                  <li><a href="<?php echo sprintf('index.php?section=%s&module=%s&method=%s', $path, $file, $method) ?>"  title="View all posts filed under Ajax"><?php echo ucfirst(str_replace('_', ' ', $method)) ?></a></li>
                </ul>
                <?php endif; ?>
              <?php endwhile;?>
          </li>
          <?php endif; ?>
        <?php endwhile;?>
        </ul>
		  </li>
		</ul>
	</div>

  <?php closedir($dir_handle); ?>

  <?php
  $path = "examples";
  $dir_handle = @opendir($path) or die("Unable to open '$path' source dir.");
  ?>
  <h2 class="jq-clearfix roundTop section-title">Demos</h2>
  <div class="roundBottom jq-box">
		<ul class="xoxo">
		  <li>
        <ul>
        <?php while ($file = readdir($dir_handle)): ?>
        <?php if(!is_dir($file) && !in_array($file, $noList)): ?>
          <li><a href="#" class="super"  title="View all posts filed under <?php echo ucfirst($file) ?>"><span>-</span> <?php echo ucfirst($file) ?></a>
            <?php $child_dir_handle = @opendir($path . DIRECTORY_SEPARATOR . $file) or die("Unable to open '".$path . DIRECTORY_SEPARATOR . $file ."' source dir."); ?>
                <?php while ($childrenFile = readdir($child_dir_handle)): ?>
                  <?php if(!is_dir($childrenFile) && !in_array($childrenFile, $noList)): ?>
                  <?php $method = str_replace('.php', null, $childrenFile) ?>
                  <?php if(isset($_GET['module']) && $file == $_GET['module']):?>
                    <ul class="children">
                  <?php else:?>
                    <ul class="children" style="display:none">
                  <?php endif;?>
                                      <li><a href="<?php echo sprintf('index.php?section=%s&module=%s&method=%s',$path, $file, $method) ?>"  title="Show demo and source code">::<?php echo $method ?>()</a></li>
                  </ul>
                  <?php endif; ?>
                <?php endwhile;?>
          </li>
          <?php endif; ?>
        <?php endwhile;?>
        </ul>
		  </li>
		</ul>
	</div>
<?php closedir($dir_handle); ?>
<?php
  $path = "examples-ui";
  $dir_handle = @opendir($path) or die("Unable to open '$path' source dir.");
?>
  <h2 class="jq-clearfix roundTop section-title">jQueryUI</h2>
  <div class="roundBottom jq-box">
		<ul class="xoxo">
		  <li>
        <ul>
        <?php while ($file = readdir($dir_handle)): ?>
        <?php if(!is_dir($file) && !in_array($file, $noList)): ?>
          <li><a href="#" class="super"  title="View all posts filed under jQueryUI <?php echo ucfirst($file) ?>"><span>-</span> <?php echo ucfirst($file) ?></a>
            <?php $child_dir_handle = @opendir($path . DIRECTORY_SEPARATOR . $file) or die("Unable to open '".$path . DIRECTORY_SEPARATOR . $file ."' source dir."); ?>
                <?php while ($childrenFile = readdir($child_dir_handle)): ?>
                  <?php if(!is_dir($childrenFile) && !in_array($childrenFile, $noList)): ?>
                  <?php $method = str_replace('.php', null, $childrenFile) ?>
                  <?php if(isset($_GET['module']) && $file == $_GET['module']):?>
                    <ul class="children">
                  <?php else:?>
                    <ul class="children" style="display:none">
                  <?php endif;?>
                                      <li><a href="<?php echo sprintf('index.php?section=%s&module=%s&method=%s',$path, $file, $method) ?>"  title="Show demo and source code"><?php echo str_ireplace('__',' ',ucfirst($method)) ?></a></li>
                  </ul>
                  <?php endif; ?>
                <?php endwhile;?>
          </li>
          <?php endif; ?>
        <?php endwhile;?>
        </ul>
		  </li>
		</ul>
	</div>
<?php closedir($dir_handle); ?>

<?php
  $path = "plugins";
  $dir_handle = @opendir($path) or die("Unable to open '$path' source dir.");
?>
  <h2 class="jq-clearfix roundTop section-title">Plugins Support - New!</h2>
  <div class="roundBottom jq-box">
		<ul class="xoxo">
		  <li>
        <ul>
        <?php while ($file = readdir($dir_handle)): ?>
        <?php if(!is_dir($file) && !in_array($file, $noList)): ?>
          <li><a href="#" class="super"  title="View all posts filed under <?php echo ucfirst($file) ?> Plugin"><span>-</span> <?php echo ucfirst($file) ?></a>
            <?php $child_dir_handle = @opendir($path . DIRECTORY_SEPARATOR . $file) or die("Unable to open '".$path . DIRECTORY_SEPARATOR . $file ."' source dir."); ?>
                <?php while ($childrenFile = readdir($child_dir_handle)): ?>
                  <?php if(!is_dir($childrenFile) && !in_array($childrenFile, $noList)): ?>
                  <?php $method = str_replace('.php', null, $childrenFile) ?>
                  <?php if(isset($_GET['module']) && $file == $_GET['module']):?>
                    <ul class="children">
                  <?php else:?>
                    <ul class="children" style="display:none">
                  <?php endif;?>
                                      <li><a href="<?php echo sprintf('index.php?section=%s&module=%s&method=%s',$path, $file, $method) ?>"  title="Show demo and source code"><?php echo str_ireplace('__',' ',ucfirst($method)) ?></a></li>
                  </ul>
                  <?php endif; ?>
                <?php endwhile;?>
          </li>
          <?php endif; ?>
        <?php endwhile;?>
        </ul>
		  </li>
		</ul>
	</div>
<?php closedir($dir_handle); ?>

<?php
  $path = "components";
  $dir_handle = @opendir($path) or die("Unable to open '$path' source dir.");
?>
  <h2 class="jq-clearfix roundTop section-title">Components - New!</h2>
  <div class="roundBottom jq-box">
		<ul class="xoxo">
		  <li>
        <ul>
        <?php while ($file = readdir($dir_handle)): ?>
        <?php if(!is_dir($file) && !in_array($file, $noList)): ?>
          <li><a href="#" class="super"  title="View all posts filed under <?php echo ucfirst($file) ?> Component"><span>-</span> <?php echo ucfirst($file) ?></a>
            <?php $child_dir_handle = @opendir($path . DIRECTORY_SEPARATOR . $file) or die("Unable to open '".$path . DIRECTORY_SEPARATOR . $file ."' source dir."); ?>
                <?php while ($childrenFile = readdir($child_dir_handle)): ?>
                  <?php if(!is_dir($childrenFile) && !in_array($childrenFile, $noList)): ?>
                  <?php $method = str_replace('.php', null, $childrenFile) ?>
                  <?php if(isset($_GET['module']) && $file == $_GET['module']):?>
                    <ul class="children">
                  <?php else:?>
                    <ul class="children" style="display:none">
                  <?php endif;?>
                                      <li><a href="<?php echo sprintf('index.php?section=%s&module=%s&method=%s',$path, $file, $method) ?>"  title="Show demo and source code"><?php echo str_ireplace('__',' ',ucfirst($method)) ?></a></li>
                  </ul>
                  <?php endif; ?>
                <?php endwhile;?>
          </li>
          <?php endif; ?>
        <?php endwhile;?>
        </ul>
		  </li>
		</ul>
	</div>
<?php closedir($dir_handle); ?>
</div>