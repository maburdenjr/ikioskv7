<?php
		//Display Albums
		if (empty($_GET['option'])) {
			
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_listView = "SELECT * FROM sys_photo_albums WHERE deleted = '0' AND ".$SYSTEM['active_site_filter'];
		$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
		$row_listView = mysql_fetch_assoc($listView);
		$totalRows_listView = mysql_num_rows($listView);
?>
<div class="widget-popover-title">Photo Albums</div>
<div class="widget-popover-body">
<?php if ($totalRows_listView != "0") { ?>
<div class="widget-row">
<ul class="imageList">
<?php do {  ?>
  <li><a class="cmstooltip" data-panel="insertImage" data-record="<?php echo $row_listView['album_id']; ?>" data-option="showAlbum"><img src="<?php albumData($row_listView['album_id'], "album_cover", "print"); ?>" alt="<?php echo $row_listView['description']; ?>" title="<?php echo $row_listView['title']; ?>"> </a> </li>
  <?php } while ($row_listView = mysql_fetch_assoc($listView)); ?>
<ul>
</div>
<?php } else { ?>
<p>No photo albums available</p>
<?php } ?>
</div>
<?php  		
		}	// Display Albums
		if ($_GET['option'] == "showAlbum") {
			
			mysql_select_db($database_ikiosk, $ikiosk);
			$query_sys_photo_albums = "SELECT * FROM sys_photo_albums WHERE album_id = '".$_GET['recordID']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
			$sys_photo_albums = mysql_query($query_sys_photo_albums, $ikiosk) or sqlError(mysql_error());
			$row_sys_photo_albums = mysql_fetch_assoc($sys_photo_albums);
			$totalRows_sys_photo_albums = mysql_num_rows($sys_photo_albums);
			
			//Get Photos
			mysql_select_db($database_ikiosk, $ikiosk);
			$query_getPhotos = "SELECT * FROM sys_photos WHERE album_id = '".$row_sys_photo_albums['album_id']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_created DESC";
			$getPhotos = mysql_query($query_getPhotos, $ikiosk) or sqlError(mysql_error());
			$row_getPhotos = mysql_fetch_assoc($getPhotos);
			$totalRows_getPhotos = mysql_num_rows($getPhotos);
?>
<div class="widget-popover-title"><?php echo $row_sys_photo_albums['title']; ?></div>
<div class="widget-popover-body custom-scroll">
<p>Click on an image to insert it into the page.</p>
<?php if ($totalRows_getPhotos != "0") { ?>
<div class="widget-row">
<ul class="imageList">
<?php do {  ?>
<li class="full"><a class="insertCode" data-code="<?php echo htmlentities("<img src=\"".$row_getPhotos['image_resized']."\" />"); ?>"><img src="<?php echo $row_getPhotos['image_thumbnail']; ?>"  title="<?php echo $row_getPhotos['title']; ?>" /></a></li>
  <?php } while ($row_getPhotos = mysql_fetch_assoc($getPhotos)); ?>
<ul>
</div>
<?php } else { ?>
	<p>There are no photos in this album.  You may upload photos by clicking on the <i class="fa fa-cog"></i> button at the top of the page.</p>
<?php } ?>
</div>
<?php
		} //Display Album Images
	?>