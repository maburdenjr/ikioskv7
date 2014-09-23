<?php 
//List View
mysql_select_db($database_ikiosk, $ikiosk);
$query_listView = "SELECT * FROM cms_blog_articles WHERE deleted = '0' AND  ".$SYSTEM['active_site_filter'];
$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
$row_listView = mysql_fetch_assoc($listView);
$totalRows_listView = mysql_num_rows($listView);
?>

<div class="modal-header">
  <h4 class="modal-title">Blog Articles</h4>
</div>
<div class="modal-body no-padding">
<div class="system-message"></div>
<table id="dt-blogArticles" class="table table-striped table-hover" width="100%">
  <thead>
    <tr>
      <th>Title</th>
      <th>Version</th>
      <th>Date Created</th>
      <th>Date Modified</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php if ($totalRows_listView != 0) { do { 
		   $article = getBlogArticle($row_listView['article_id']);	
	?>
      <tr class="<?php echo $row_listView['article_id']; ?>">
      <td><a href="/blog/articles/<?php echo $article['permalink_filename']; ?>?mode=draft&version_id=<?php echo $article['article_version_id']; ?>"><?php echo $article['title']; ?></a></td>
      <td><?php echo $article['version']; ?></td>
      <td><?php timezoneProcess($row_listView['date_created'], "print"); ?></td>
      <td><?php timezoneProcess($article['date_modified'], "print"); ?></td>
      <td class="icon"><a class="delete-record" data-table="cms_blog_articles" data-record="<?php echo $row_listView['article_id']; ?>" data-code="CMS" data-field="article_id"><i class="fa fa-trash-o"></i></a></td>
  <?php } while ($row_listView = mysql_fetch_assoc($listView)); } ?>
  </tbody>
</table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
</div>
</div>
<script type="text/javascript">
		var listView = $('#dt-blogArticles').dataTable({
				"order": [[	3, "desc"]]
			});
</script> 