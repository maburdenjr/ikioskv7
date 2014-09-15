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


$restricted = array(".", "..", "/static/resources", "cms", "blog", "system", ".htaccess");

if (empty($_GET['action'])) { ?>
<div class="modal-header">
  <h4 class="modal-title">File Manager</h4>
</div>
<div class="modal-body">

	<div class="enhanced-well">
  	<div class="pull-left">
    <?php if (!empty($parentFolder)) { ?>
  		<a class="btn btn-default modalDynLink" href="/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=CMS&directory=<?php echo $parentFolder; ?>"><i class="fa fa-mail-reply"></i></a>
    <?php } ?>  
			<a class="btn btn-default"><?php echo str_replace("//", "/", $parentFolder.$activeFolder); ?></a>
     </div>
     <div class="pull-right"> 
    	<a class="btn btn-default panelTrigger" data-panel="file-newFolder"><i class="fa fa-plus"></i> New Folder</a>
      <a class="btn btn-primary"><i class="fa fa-cloud-upload"></i> Upload Files</a>
     </div>
  </div>
  <div id="file-newFolder" class="enhanced-well hide-me">
  
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
			switch($extension) {
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
					$icon = "<img class=\"icon-image\" src=\"".$value."\" />";
					break;	
				case "jpeg":
					$icon = "<img class=\"icon-image\" src=\"".$value."\" />";
					break;		
				case "gif":
					$icon = "<img class=\"icon-image\" src=\"".$value."\" />";
					break;	
				case "png":
					$icon = "<img class=\"icon-image\" src=\"".$value."\" />";
					break;			
				default: 
					$icon = "<i class=\"fa fa-4x fa-file-text-o\"></i>";
					break;
			}	
			
			$iconLink = "<a href=\"".$SITE['site_url'].$activeFolder."/".$value."\" target=\"_blank\" class=\"icon-link\">".$icon."</a><div class=\"file-title\"><a href=\"".$SITE['site_url'].$activeFolder."/".$value."\" target=\"_blank\" class=\"icon-text\">".$value."</a></div>";	
	}
 ?>
	<div class="col-md-2 col-sm-2 col-xs-6"><div class="file-wrapper"><?php echo $iconLink; ?></div></div>
 <?php } } ?> 
  </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
</div>
<?php } ?>