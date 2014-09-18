<?php
//List View
mysql_select_db($database_ikiosk, $ikiosk);
$query_listView = "SELECT * FROM cms_page_elements WHERE deleted = '0' AND  ".$SYSTEM['active_site_filter'];
$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
$row_listView = mysql_fetch_assoc($listView);
$totalRows_listView = mysql_num_rows($listView);
?>
<div class="widget-popover-title">Code Snippets</div>
<div class="widget-popover-body custom-scroll">
<?php if ($totalRows_listView != 0) { ?>
<div id="codePreview" class="hide-me">
	<p class="snippetTitle"></p>
	<pre class="htmlCode prettyprint custom-scroll">
  </pre>
  <div class="align-right">
   <a class="btn btn-default panelToggle" title="Back to Snippet List" data-open="codeList" data-close="codePreview"><i class="fa fa-reply"></i></a>
   <a class="btn btn-primary btn-labeled insertCode" title="Insert Code" data-code="">
   <span class="btn-label"><i class="fa fw fa-code"></i></span> Insert Code</a>
   </div>
</div>
<div id="codeList">
<?php  do { ?>
<a class="btn btn-default inlineBtn codePreview panelToggle" data-htmlcode="<?php echo htmlentities($row_listView['content']); ?>" data-code="<?php echo htmlentities("<span class=\"ikiosk-cmsSnippet\">snippet:".$row_listView['page_element_id']."</span>"); ?>" data-title="<?php echo $row_listView['title']; ?>" data-close="codeList" data-open="codePreview"><?php echo $row_listView['title']; ?></a>
<?php } while ($row_listView = mysql_fetch_assoc($listView)); ?>
</div>
<?php  } else { ?>
  <p>There are no code snippets for this site.  You can add snippets by clicking on the <i class="fa fa-cog"></i> button at the top of the page.</p>
<?php } ?>
</div>
  