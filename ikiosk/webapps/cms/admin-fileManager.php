<?php 
//Default File Settings
if (empty($_GET['directory']) || ($_GET['directory'] == "/")) {
	$localDirectory = "/";
	$serverDirectory = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'];
	$activeFolder = "/";
	$_GET['directory'] = "/";
} else {
	$localDirectory = $_GET['directory'];
	$serverDirectory = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'].$_GET['directory'];
	$activeFolder = $localDirectory;
	$activeFolder = "/".substr(strrchr($localDirectory, "/"), 1);
	$parentFolder = "/".str_replace($activeFolder, "", $localDirectory);
	$parentFolder = str_replace("//", "/", $parentFolder);
	$thisFolder = str_replace("//", "/", $parentFolder.$activeFolder);
	
}

$dh  = opendir($serverDirectory);
	while (false !== ($filename = readdir($dh))) {
    $fileArray[] = $filename;
}


$restricted = array(".", "..", "resources", "cms", "blog", "system", ".htaccess");
$currentDir = str_replace("//", "/", $parentFolder.$activeFolder);

if (empty($_GET['action'])) { ?>

<div class="modal-header">
  <h4 class="modal-title">File Manager</h4>
</div>
<div class="modal-body">
  <div class="system-message"></div>
  <?php if ($_GET['option'] != "fileViewer") { ?>
  <div class="enhanced-well">
    <div class="pull-left">
      <?php if (!empty($parentFolder)) { ?>
      <a class="btn btn-default parentDir modalDynLink" href="/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=<?php echo $parentFolder; ?>"><i class="fa fa-mail-reply"></i></a>
   
      <a class="btn btn-default panelTrigger" data-panel="file-renameFolder"><i class="fa fa-edit"></i></a>
         <?php if ($thisFolder != "/static") { ?>
      <a class="btn btn-default cms-action" data-action="deleteDir" data-record="<?php echo $currentDir; ?>" data-confirm="Are you sure you want to delete this directory?"><i class="fa fa-trash-o"></i></a>
      <?php } ?>
      <?php } ?>
      <a class="btn btn-default fileSelf modalDynLink hidden-mobile" href="/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=<?php echo $currentDir; ?>"><?php echo $currentDir; ?></a>
      <a class="btn btn-default cms-action refreshFiles hidden-mobile" data-action="refreshFiles" data-record="<?php echo $currentDir; ?>" data-confirm="none"><i class="fa fa-refresh"></i></a>
       </div>
      
    <div class="pull-right"> <a class="btn btn-default panelTrigger" data-panel="file-newFolder"><i class="fa fa-plus"></i> <span class="hidden-mobile">New Directory</span></a> <a class="btn btn-primary panelTrigger" data-panel="file-uploadFiles"><i class="fa fa-cloud-upload"></i> <span class="hidden-mobile">Upload Files</span></a> </div>
  </div>
  <!-- Rename -->
  <div id="file-renameFolder" class="enhanced-well hide-me">
    <form id = "cms-renameFolder" class="smart-form">
      <div class="form-response"></div>
      <section>
        <label class="label">Directory Name</label>
        <div class="note">Directory name should only include alphanumeric characters</div>
        <label class="input">
          <input type="text" name="foldername" value="<?php echo str_replace("/", "", $activeFolder); ?>" />
        </label>
      </section>
      <div class="align-right">
        <button type="button" class="btn btn-default panelTrigger" data-panel="file-renameFolder"><i class="fa fa-times"></i> Cancel </button>
        <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-renameFolder"> <i class="fa fa-check"></i> Save </button>
        <input type="hidden" name="formID" value="cms-renameFolder">
        <input type="hidden" name="original" value="<?php echo $currentDir; ?>" />
        <input type="hidden" name="parent" value="<?php echo $parentFolder; ?>" />
        <input type="hidden" name="iKioskForm" value="Yes" />
        <input type="hidden" name="appCode" value="CMS" />
      </div>
    </form>
    <script type="text/javascript">
  $(function() {
		 $("#cms-renameFolder").validate({
				 rules : {
					foldername : {
						required : true
					}
				},
				
				messages : {
					foldername : {
						required : 'Please enter a name for this directory'
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
  <!-- Upload Files -->
  <div id="file-uploadFiles" class="enhanced-well hide-me"> </div>
  <!-- New Folder -->
  <div id="file-newFolder" class="enhanced-well hide-me">
    <form id = "cms-newFileFolder" class="smart-form">
      <div class="form-response"></div>
      <section>
        <label class="label">Directory Name</label>
        <div class="note">Directory name should only include alphanumeric characters</div>
        <label class="input">
          <input type="text" name="foldername" />
        </label>
      </section>
      <div class="align-right">
        <button type="button" class="btn btn-default panelTrigger" data-panel="file-newFolder"><i class="fa fa-times"></i> Cancel </button>
        <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-newFileFolder"> <i class="fa fa-check"></i> Save </button>
        <input type="hidden" name="formID" value="cms-newFileFolder">
        <input type="hidden" name="parent" value="<?php echo $currentDir; ?>" />
        <input type="hidden" name="iKioskForm" value="Yes" />
        <input type="hidden" name="appCode" value="CMS" />
      </div>
    </form>
    <script type="text/javascript">
 pageSetUp();
  $(function() {
		 $("#cms-newFileFolder").validate({
				 rules : {
					foldername : {
						required : true
					}
				},
				
				messages : {
					foldername : {
						required : 'Please enter a name for this directory'
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
<script type="text/javascript" language="javascript">
function createUploader(targetFolder){         
	var uploader = new qq.FileUploader({
		element: document.getElementById('file-uploadFiles'),
		action: '/cms/ajaxHandler.php?appCode=CMS&ajaxAction=uploadFiles&filePath=<?php echo $serverDirectory; ?>/',
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
  </div>
  <div id="fileList" class="row">
    <?php 
 foreach ($fileArray as $key => $value) {  
 if (!in_array($value, $restricted)) {
	 
	$activeFile = $serverDirectory."/".$value;
	$modDate = (filemtime($activeFile));
	$modDate = date("m/d/Y g:i:s a", $modDate);
	
	if(is_dir($activeFile)) {
			$iconLink = "<a href=\"/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=".$thisFolder."/".$value."\" class=\"modalDynLink icon-link\"><i class=\"fa fa-4x fa-folder\"></i></a><div class=\"file-title\"><a href=\"/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=".$thisFolder."/".$value."\" class=\"modalDynLink icon-text\">".$value."</a></div>";
	} else {
			$extension = explode(".", $value);
			$extension = end($extension);
			switch(strtolower($extension)) {
				case "html":
					$icon = "<i class=\"fa fa-4x fa-file-code-o\"></i>";
					break;
				case "htm":
					$icon = "<i class=\"fa fa-4x fa-file-code-o\"></i>";
					break;	
				case "php":
					$icon = "<i class=\"fa fa-4x fa-file-code-o\"></i>";
					break;		
				case "jpg":
					$icon = "<img class=\"icon-image\" src=\"".$thisFolder."/".$value."\" />";
					break;	
				case "jpeg":
					$icon = "<img class=\"icon-image\" src=\"".$thisFolder."/".$value."\" />";
					break;		
				case "gif":
					$icon = "<img class=\"icon-image\" src=\"".$thisFolder."/".$value."\" />";
					break;	
				case "png":
					$icon = "<img class=\"icon-image\" src=\"".$thisFolder."/".$value."\" />";
					break;			
				default: 
					$icon = "<i class=\"fa fa-4x fa-file-text-o\"></i>";
					break;
			}	
			
			$iconLink = "<a href=\"/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=".$thisFolder."&option=fileViewer&file=".$value."\" class=\"icon-link modalDynLink\">".$icon."</a><div class=\"file-title\"><a  href=\"/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=".$thisFolder."&option=fileViewer&file=".$value."\" class=\"icon-text modalDynLink\">".$value."</a></div>";	
	}
 ?>
    <div class="col-md-2 col-sm-2 col-xs-6">
      <div class="file-wrapper"><?php echo $iconLink; ?></div>
    </div>
    <?php } } ?>
  </div>
  <?php } else { ?>
  <div class="enhanced-well">
    <div class="pull-left"> <a class="btn btn-default parentDir modalDynLink" href="/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=<?php echo $currentDir; ?>"><i class="fa fa-mail-reply" rel="tooltip" title="Back to directory listing"></i></a> 
    
     <a class="btn btn-default panelTrigger" data-panel="file-renameFile"><i class="fa fa-edit"></i></a>

    
    <a class="btn btn-default cms-action" data-action="deleteFile" data-record="<?php echo $currentDir."/".$_GET['file']; ?>" data-confirm="Are you sure you want to delete this file?" rel="tooltip" title="Delete this file"><i class="fa fa-trash-o"></i></a> 
    
    <a class="btn btn-default fileSelf modalDynLink hidden-mobile" href="/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=<?php echo $currentDir; ?>"><?php echo $currentDir."/".$_GET['file']; ?></a> </div>
  </div>
  <!-- Rename -->
  <div id="file-renameFile" class="enhanced-well hide-me">
    <form id = "cms-renameFile" class="smart-form">
      <div class="form-response"></div>
      <section>
        <label class="label">Filename</label>
        <label class="input">
          <input type="text" name="filename" value="<?php echo $_GET['file']; ?>" />
        </label>
      </section>
      <div class="align-right">
        <button type="button" class="btn btn-default panelTrigger" data-panel="file-renameFile"><i class="fa fa-times"></i> Cancel </button>
        <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-renameFile"> <i class="fa fa-check"></i> Save </button>
        <input type="hidden" name="formID" value="cms-renameFile">
        <input type="hidden" name="original" value="<?php echo $currentDir."/".$_GET['file']; ?>" />
        <input type="hidden" name="parent" value="<?php echo $currentDir; ?>" />
        <input type="hidden" name="iKioskForm" value="Yes" />
        <input type="hidden" name="appCode" value="CMS" />
      </div>
    </form>
    <script type="text/javascript">
  $(function() {
		 $("#cms-renameFile").validate({
				 rules : {
					filename : {
						required : true
					}
				},
				
				messages : {
					filename : {
						required : 'Please enter a name for this file'
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
  <iframe src="<?php echo $SITE['site_url'].$currentDir."/".$_GET['file']; ?>?editor=off" class="fileViewer custom-scroll"></iframe>
  <?php } ?>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
</div>
<?php } ?>
<?php if ((!empty($_GET['action'])) && ($_GET['action'] == "refreshFiles")) { ?>
    <?php 
 foreach ($fileArray as $key => $value) {  
 if (!in_array($value, $restricted)) {
	 
	$activeFile = $serverDirectory."/".$value;
	$modDate = (filemtime($activeFile));
	$modDate = date("m/d/Y g:i:s a", $modDate);
	
	if(is_dir($activeFile)) {
			$iconLink = "<a href=\"/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=".$thisFolder."/".$value."\" class=\"modalDynLink icon-link\"><i class=\"fa fa-4x fa-folder\"></i></a><div class=\"file-title\"><a href=\"/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=".$thisFolder."/".$value."\" class=\"modalDynLink icon-text\">".$value."</a></div>";
	} else {
			$extension = explode(".", $value);
			$extension = end($extension);
			switch(strtolower($extension)) {
				case "html":
					$icon = "<i class=\"fa fa-4x fa-file-code-o\"></i>";
					break;
				case "htm":
					$icon = "<i class=\"fa fa-4x fa-file-code-o\"></i>";
					break;	
				case "php":
					$icon = "<i class=\"fa fa-4x fa-file-code-o\"></i>";
					break;		
				case "jpg":
					$icon = "<img class=\"icon-image\" src=\"".$thisFolder."/".$value."\" />";
					break;	
				case "jpeg":
					$icon = "<img class=\"icon-image\" src=\"".$thisFolder."/".$value."\" />";
					break;		
				case "gif":
					$icon = "<img class=\"icon-image\" src=\"".$thisFolder."/".$value."\" />";
					break;	
				case "png":
					$icon = "<img class=\"icon-image\" src=\"".$thisFolder."/".$value."\" />";
					break;			
				default: 
					$icon = "<i class=\"fa fa-4x fa-file-text-o\"></i>";
					break;
			}	
			
			$iconLink = "<a href=\"/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=".$thisFolder."&option=fileViewer&file=".$value."\" class=\"icon-link modalDynLink\">".$icon."</a><div class=\"file-title\"><a  href=\"/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=".$thisFolder."&option=fileViewer&file=".$value."\" class=\"icon-text modalDynLink\">".$value."</a></div>";	
	}
 ?>
<div class="col-md-2 col-sm-2 col-xs-6"><div class="file-wrapper"><?php echo $iconLink; ?></div></div><?php } } ?>
<?php } ?>