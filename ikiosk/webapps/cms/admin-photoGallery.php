<?php if (empty($_GET['action'])) { 
mysql_select_db($database_ikiosk, $ikiosk);
$query_listView = "SELECT * FROM sys_photo_albums WHERE deleted = '0' AND ".$SYSTEM['active_site_filter'];
$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
$row_listView = mysql_fetch_assoc($listView);
$totalRows_listView = mysql_num_rows($listView);
?>
<div class="modal-header">
  <h4 class="modal-title">Photo Albums</h4>
</div>
<div class="modal-body">
  <div class="system-message"></div>
  	<div class="enhanced-well">
    	<div class="pull-right">
      <a class="btn btn-default panelTrigger" data-panel="photo-newAlbum"><i class="fa fa-plus"></i> <span class="hidden-mobile">New Album</span></a>
      <a href="/cms/ajaxHandler.php?ajaxAction=photoGallery&appCode=CMS" class="modalDynLink dynRefresh hide-me"></a>
      </div>
		</div>
    <div id="photo-newAlbum" class="enhanced-well hide-me">
      <form id = "cms-newPhotoAlbum" class="smart-form">
       <div class="form-response"></div>
      <section>
        <label class="label">Album Title</label>
        <label class="input">
          <input type="text" name="title" />
        </label>
        </section>
        <section>
        <label class="label">Description</label>
        <label class="textarea">
        	  <textarea rows="3" class="custom-scroll" name="description"></textarea>
        </label>
      </section>
      <div class="align-right">
        <button type="button" class="btn btn-default panelTrigger" data-panel="photo-newAlbum"><i class="fa fa-times"></i> Close </button>
        <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-newPhotoAlbum"> <i class="fa fa-check"></i> Save </button>
        <input type="hidden" name="formID" value="cms-newPhotoAlbum">
        <input type="hidden" name="iKioskForm" value="Yes" />
        <input type="hidden" name="appCode" value="CMS" />
      </div>
      </form>
<script type="text/javascript">
  $(function() {
		 $("#cms-newPhotoAlbum").validate({
				 rules : {
					title : {
						required : true
					}
				},
				
				messages : {
					title : {
						required : 'Please enter a name for this photo album'
					}
				},
				
				errorPlacement : function(error, element) {
					error.insertAfter(element.parent());
				},
				submitHandler: function(form) {
					var targetForm = $(this.currentForm).attr("id");
					 submitAjaxForm(targetForm);
				 }
		 });
   });
</script> 
    </div>
    
    <!-- Album List -->
    <div id="photoGrid" class="row">
   		<div class="superbox col-sm-12">
      	<?php if ($totalRows_listView != "0") { do {  ?>
        <div class="superbox-list">
          <a href="/cms/ajaxHandler.php?ajaxAction=photoGallery&appCode=CMS&action=viewAlbum&recordID=<?php echo $row_listView['album_id']; ?>" class="modalDynLink"><img src="<?php albumData($row_listView['album_id'], "album_cover", "print"); ?>" alt="<?php echo $row_listView['description']; ?>" title="<?php echo $row_listView['title']; ?>"  class="superbox-img">
          </a>

          <div class="note"><a href="/cms/ajaxHandler.php?ajaxAction=photoGallery&appCode=CMS&action=viewAlbum&recordID=<?php echo $row_listView['album_id']; ?>" class="modalDynLink"><?php echo $row_listView['title']; ?></a></div>
          	
        </div>
				<?php } while ($row_listView = mysql_fetch_assoc($listView)); } ?>
      </div> 
    </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
</div>
<?php } else { ?>
<?php if ($_GET['action'] == "viewAlbum") { 
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
<div class="modal-header">
  <h4 class="modal-title"><?php echo $row_sys_photo_albums['title']; ?></h4>
  <small><a href="/cms/ajaxHandler.php?ajaxAction=cmsAdmin&appCode=CMS" class="dynamicModal">CMS</a> > <a href="/cms/ajaxHandler.php?ajaxAction=photoGallery&appCode=CMS" class="modalDynLink">Photo Albums</a></small>
</div>
<div class="modal-body">
  <div class="system-message"></div>
  	<div class="enhanced-well">
    	<div class="pull-left">
      <a href="/cms/ajaxHandler.php?ajaxAction=photoGallery&appCode=CMS&action=viewAlbum&recordID=<?php echo $row_sys_photo_albums['album_id']; ?>" class="modalDynLink dynRefresh hide-me"></a>
      <a class="btn btn-default parentAlbum modalDynLink" href="/cms/ajaxHandler.php?ajaxAction=photoGallery&appCode=CMS"><i class="fa fa-mail-reply"></i></a>
      	<a class="btn btn-default panelTrigger" data-panel="cms-editPhotoAlbum"><i class="fa fa-edit"></i></a>
	      <a class="btn btn-default cms-action" data-action="deletePhotoAlbum" data-record="<?php echo $row_sys_photo_albums['album_id']; ?>" data-confirm="Are you sure you want to delete this album?"><i class="fa fa-trash-o"></i></a>
        <a class="btn btn-default cms-action refreshFiles hidden-mobile" data-action="refreshPhotos" data-record="<?php echo $row_sys_photo_albums['album_id']; ?>" data-confirm="none"><i class="fa fa-refresh"></i></a>

      </div>
      <div class="pull-right">
      <a class="btn btn-primary panelTrigger" data-panel="file-uploadFiles"><i class="fa fa-cloud-upload"></i> <span class="hidden-mobile">Upload Photos</span></a>
      </div>
    </div>
    <!-- Upload Photos -->
    <div id="file-uploadFiles" class="enhanced-well hide-me">
    </div>
    <script type="text/javascript" language="javascript">
		function createUploader(targetFolder){         
			var uploader = new qq.FileUploader({
				element: document.getElementById('file-uploadFiles'),
				action: '/cms/ajaxHandler.php?appCode=CMS&ajaxAction=uploadPhotos&recordID=<?php echo $row_sys_photo_albums['album_id']; ?>',
				debug: true,
				 params: {
					process: targetFolder
				},
				onComplete: function(){
					jQuery('.refreshFiles').click();
					jQuery('.alert-warning .fa').removeClass('fa-check').addClass('fa-warning');
				}
			});           
		}
		</script>
    <!-- Edit Photo Album -->
    <div id="cms-editPhotoAlbum" class="enhanced-well hide-me">
    		 <form id = "cms-editAlbumPhoto" class="smart-form">
       <div class="form-response"></div>
      <section>
        <label class="label">Album Title</label>
        <label class="input">
          <input type="text" name="title" value="<?php echo $row_sys_photo_albums['title']; ?>" />
        </label>
        </section>
        <section>
        <label class="label">Description</label>
        <label class="textarea">
        	  <textarea rows="3" class="custom-scroll" name="description"><?php echo $row_sys_photo_albums['description']; ?></textarea>
        </label>
      </section>
      <div class="align-right">
        <button type="button" class="btn btn-default panelTrigger" data-panel="cms-editPhotoAlbum"><i class="fa fa-times"></i> Close </button>
        <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-editAlbumPhoto"> <i class="fa fa-check"></i> Save </button>
       	 <input type="hidden" name="album_id" value="<?php echo $row_sys_photo_albums['album_id']; ?>">
        <input type="hidden" name="formID" value="cms-editAlbumPhoto">
        <input type="hidden" name="iKioskForm" value="Yes" />
        <input type="hidden" name="appCode" value="CMS" />
      </div>
      </form>
		<script type="text/javascript">
      $(function() {
         $("#cms-editAlbumPhoto").validate({
             rules : {
              title : {
                required : true
              }
            },
            
            messages : {
              title : {
                required : 'Please enter a name for this photo album'
              }
            },
            
            errorPlacement : function(error, element) {
              error.insertAfter(element.parent());
            },
            submitHandler: function(form) {
              var targetForm = $(this.currentForm).attr("id");
               submitAjaxForm(targetForm);
             }
         });
       });
    </script> 
    </div>
    <div id="photoList">
   		<div class="superbox col-sm-12">
      <?php if ($totalRows_getPhotos != "0") { do {  ?>
<div class="superbox-list"><img src="<?php echo $row_getPhotos['image_thumbnail']; ?>" data-img="<?php echo $row_getPhotos['image_original']; ?>" alt="<?php echo $row_getPhotos['description']; ?>" title="<?php echo $row_getPhotos['title']; ?>" class="superbox-img" data-description="<?php echo $row_getPhotos['description']; ?>" data-photoid="<?php echo $row_getPhotos['photo_id']; ?>"></div><?php } while ($row_getPhotos = mysql_fetch_assoc($getPhotos)); }?>
			</div>
    </div>
    <form id = "cms-editPhoto" class="smart-form">
        <div class="form-response"></div>
    		<section>
        <label class="label">Title</label>
        <label class="input">
          <input type="text" name="title" value="" />
        </label>
        </section>
        <section>
        <label class="label">Caption / Description</label>
        <label class="textarea">
        	  <textarea rows="3" class="custom-scroll" name="description"></textarea>
        </label>
      	</section>
        <div class="align-right">
        <a class="btn btn-danger cms-action" data-action="deletePhoto" data-record="" data-confirm="Are you sure you want to delete this photo?"><i class="fa fa-trash-o"></i> Delete</a>
        <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-editPhoto"> <i class="fa fa-check"></i> Save </button>
       	 <input type="hidden" name="photo_id" value="">
        <input type="hidden" name="formID" value="cms-editPhoto">
        <input type="hidden" name="iKioskForm" value="Yes" />
        <input type="hidden" name="appCode" value="CMS" />
      </div>
		</form>
    <script type="text/javascript">
      $(function() {
         $("#cms-editPhoto").validate({            
            errorPlacement : function(error, element) {
              error.insertAfter(element.parent());
            },
            submitHandler: function(form) {
              var targetForm = $(this.currentForm).attr("id");
               submitAjaxForm(targetForm);
             }
         });
       });
    </script> 
     <script type="text/javascript">
		 		$('.superbox').SuperBox();
		 </script>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
</div>
<?php } ?>
<?php
if ($_GET['action'] == "refreshPhotos") { 
//Get Photos
mysql_select_db($database_ikiosk, $ikiosk);
$query_getPhotos = "SELECT * FROM sys_photos WHERE album_id = '".$_GET['recordID']."' AND deleted = '0' AND site_id  = '".$SITE['site_id']."' ORDER BY date_created DESC";
$getPhotos = mysql_query($query_getPhotos, $ikiosk) or sqlError(mysql_error());
$row_getPhotos = mysql_fetch_assoc($getPhotos);
$totalRows_getPhotos = mysql_num_rows($getPhotos);
?>
<?php if ($totalRows_getPhotos != "0") { do {  ?>
<div class="superbox-list"><img src="<?php echo $row_getPhotos['image_thumbnail']; ?>" data-img="<?php echo $row_getPhotos['image_original']; ?>" alt="<?php echo $row_getPhotos['description']; ?>" title="<?php echo $row_getPhotos['title']; ?>" class="superbox-img" data-description="<?php echo $row_getPhotos['description']; ?>" data-photoid="<?php echo $row_getPhotos['photo_id']; ?>"></div><?php } while ($row_getPhotos = mysql_fetch_assoc($getPhotos)); }?>
<?php } ?>
<?php } ?>

